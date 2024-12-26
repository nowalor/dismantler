<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;
use App\Enums\TargetLanguages;


class TranslateLocalizationFiles extends Command
{
    protected $signature = 'localization:translate';
    protected $description = 'Translate JSON and PHP localization files using DeepL API while preserving existing translations';
    protected array $doNotTranslateKeys = ['categories', 'question', 'answer'];
    private Client $client;
    private string $apiKey;

    // Source language constant
    private const SOURCE_LANG = 'en';

    public function __construct()
    {
        parent::__construct();

        $this->client = new Client([
            'base_uri' => config('services.deepl.base_url') ?? '',
        ]);

        $this->apiKey = config('services.deepl.api_key') ?? '';
    }

    public function handle(): int
    {
        if (!$this->apiKey) {
            $this->error('DeepL API key is missing in the configuration file.');
            return Command::FAILURE;
        }

        $targetLangs = TargetLanguages::getLanguages();
        if (empty($targetLangs)) {
            $this->error('No target languages are defined in the DeepL configuration.');
            return Command::FAILURE;
        }

        // 1. Translate JSON files
        $this->translateJsonFile($targetLangs);

        // 2. Translate PHP array files
        $phpFiles = [
            'part-types.php',
            'pagination.php',
            'faqs.php',
            'checkout.php',
            'payment-success.php',
            'car-part-types.php',
            'page-titles.php',
            'alt-tags.php',
            'countries.php',
        ];

        foreach ($phpFiles as $phpFile) {
            $this->translateFile($phpFile, $targetLangs);
        }

        $this->info("All files have been translated successfully!");
        return Command::SUCCESS;
    }

    protected function translateJsonFile(array $targetLangs): void
    {
        $sourceFilePath = base_path("lang/" . self::SOURCE_LANG . ".json");
        if (!File::exists($sourceFilePath)) {
            $this->error("Source JSON file not found: {$sourceFilePath}");
            return;
        }

        $sourceContent = json_decode(File::get($sourceFilePath), true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->error("Invalid JSON in source file: {$sourceFilePath}");
            return;
        }

        foreach ($targetLangs as $langDir => $langCode) {
            $this->info("Translating JSON file to {$langCode}...");

            $targetFilePath = base_path("lang/{$langDir}.json");
            $targetContent = File::exists($targetFilePath)
                ? json_decode(File::get($targetFilePath), true)
                : [];

            foreach ($sourceContent as $key => $text) {
                if (!empty($targetContent[$key])) {
                    continue;
                }

                if (is_string($text)) {
                    $translatedText = $this->translateString($text, self::SOURCE_LANG, $langCode);
                    $targetContent[$key] = $translatedText ?: $text;
                } else {
                    $targetContent[$key] = $text;
                }
            }

            File::put($targetFilePath, json_encode($targetContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("JSON translation saved to {$targetFilePath}");
        }
    }

    protected function translateFile(string $file, array $targetLangs)
    {
        $sourcePath = base_path("lang/" . self::SOURCE_LANG . "/{$file}");

        if (!File::exists($sourcePath)) {
            $this->error("Source file not found: {$sourcePath}");
            return;
        }

        $sourceArray = require $sourcePath;

        foreach ($targetLangs as $langDir => $langCode) {
            $this->info("Translating {$file} to {$langCode}...");

            $targetPath = base_path("lang/{$langDir}/{$file}");
            $targetArray = File::exists($targetPath) ? (require $targetPath) : [];
            $translatedArray = $this->translateContent($sourceArray, $targetArray, $langCode);
            $phpContent = $this->exportArray($translatedArray);

            File::ensureDirectoryExists(dirname($targetPath));
            File::put($targetPath, $phpContent);

            $this->info("Translation saved to {$targetPath}");
        }
    }

    protected function translateContent(array $source, array $target, string $targetLang)
    {
        $translated = [];

        foreach ($source as $key => $value) {
            if (isset($target[$key])) {
                $translated[$key] = $target[$key];
                continue;
            }

            if ($key === 'categories') {
                $translated[$key] = $this->translateCategories($value, $target[$key] ?? [], $targetLang);
            } elseif (is_string($value)) {
                $translated[$key] = $this->translateString($value, self::SOURCE_LANG, $targetLang);
            } elseif (is_array($value)) {
                $translated[$key] = $this->translateContent($value, $target[$key] ?? [], $targetLang);
            } else {
                $translated[$key] = $value;
            }
        }

        return $translated;
    }

    protected function translateCategories(array $sourceCategories, array $targetCategories, string $targetLang)
    {
        $translatedCategories = [];

        foreach ($sourceCategories as $categoryKey => $items) {
            $translatedCategoryKey = $this->translateString($categoryKey, self::SOURCE_LANG, $targetLang);

            $translatedCategories[$translatedCategoryKey] = [];
            foreach ($items as $item) {
                $translatedItem = [];
                foreach ($item as $fieldKey => $fieldValue) {
                    if (in_array($fieldKey, ['question', 'answer'], true) && is_string($fieldValue)) {
                        $translatedItem[$fieldKey] = $this->translateString($fieldValue, self::SOURCE_LANG, $targetLang);
                    } else {
                        $translatedItem[$fieldKey] = $fieldValue;
                    }
                }

                $translatedCategories[$translatedCategoryKey][] = $translatedItem;
            }
        }

        return $translatedCategories;
    }

    protected function translateString(string $text, string $sourceLang, string $targetLang)
    {
        try {
            $response = $this->client->post('translate', [
                'form_params' => [
                    'auth_key' => $this->apiKey,
                    'text' => $text,
                    'source_lang' => strtoupper($sourceLang),
                    'target_lang' => strtoupper($targetLang),
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            return $responseBody['translations'][0]['text'] ?? $text;
        } catch (\Exception $e) {
            $this->error("Error translating '{$text}': " . $e->getMessage());
            return $text;
        }
    }

    protected function exportArray(array $array): string
    {
        $export = var_export($array, true);
        return "<?php\n\nreturn {$export};\n";
    }
}
