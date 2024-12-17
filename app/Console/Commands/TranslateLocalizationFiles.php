<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;

class TranslateLocalizationFiles extends Command
{
    protected $signature = 'localization:translate';
    protected $description = 'Translate JSON and PHP localization files using DeepL API while preserving existing translations';

    protected $doNotTranslateKeys = ['categories', 'question', 'answer'];

    public function handle()
    {
        $sourceLang = 'en';
        $deeplApiKey = env('DEEPL_TRANSLATE');

        if (!$deeplApiKey) {
            $this->error('DeepL API key is missing in .env file.');
            return Command::FAILURE;
        }

        $targetLangs = [
            'dk' => 'DA', // Danish
            'fr' => 'FR', // French
            'se' => 'SV', // Swedish
            'ge' => 'DE', // German
            'it' => 'IT', // Italian
            'pl' => 'PL', // Polish
        ];

        $client = new Client(['base_uri' => 'https://api-free.deepl.com/v2/']);

        // 1. Translate JSON files
        $this->translateJsonFile($sourceLang, $targetLangs, $client, $deeplApiKey);

        // 2. Translate PHP array files
        $phpFiles = ['part-types.php', 'pagination.php', 'faqs.php'];
        foreach ($phpFiles as $phpFile) {
            $this->translateFile($sourceLang, $phpFile, $targetLangs, $client, $deeplApiKey);
        }

        $this->info("All files have been translated successfully!");
        return Command::SUCCESS;
    }

    protected function translateJsonFile($sourceLang, $targetLangs, $client, $apiKey)
    {
        $sourceFilePath = base_path("lang/{$sourceLang}.json");

        if (!File::exists($sourceFilePath)) {
            $this->error("Source JSON file not found: {$sourceFilePath}");
            return;
        }

        $sourceContent = json_decode(File::get($sourceFilePath), true);

        foreach ($targetLangs as $langDir => $deeplCode) {
            $this->info("Translating JSON file to {$langDir} ({$deeplCode})...");

            $targetFilePath = base_path("lang/{$langDir}.json");
            $targetContent = File::exists($targetFilePath)
                ? json_decode(File::get($targetFilePath), true)
                : [];

            foreach ($sourceContent as $key => $text) {
                if (!empty($targetContent[$key])) {
                    continue;
                }

                if (is_string($text)) {
                    $translatedText = $this->translateString($text, $sourceLang, $deeplCode, $client, $apiKey);
                    $targetContent[$key] = $translatedText ?: $text;
                } else {
                    $targetContent[$key] = $text;
                }
            }

            File::put($targetFilePath, json_encode($targetContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));
            $this->info("JSON translation saved to {$targetFilePath}");
        }
    }

    protected function translateFile($sourceLang, $file, $targetLangs, $client, $apiKey)
    {
        $sourcePath = base_path("lang/{$sourceLang}/{$file}");

        if (!File::exists($sourcePath)) {
            $this->error("Source file not found: {$sourcePath}");
            return;
        }

        $sourceArray = require $sourcePath;

        foreach ($targetLangs as $langDir => $deeplCode) {
            $this->info("Translating {$file} to {$langDir} ({$deeplCode})...");

            $targetPath = base_path("lang/{$langDir}/{$file}");
            $targetArray = File::exists($targetPath) ? (require $targetPath) : [];

            $translatedArray = $this->translateContent($sourceArray, $targetArray, $sourceLang, $deeplCode, $client, $apiKey);

            $phpContent = $this->exportArray($translatedArray);
            File::ensureDirectoryExists(dirname($targetPath));
            File::put($targetPath, $phpContent);

            $this->info("Translation saved to {$targetPath}");
        }
    }

    protected function translateContent($source, $target, $sourceLang, $targetLang, $client, $apiKey)
    {
        $translated = [];

        foreach ($source as $key => $value) {
            if (isset($target[$key])) {
                $translated[$key] = $target[$key];
            } elseif ($key === 'categories') {
                $translated[$key] = $this->translateCategories($value, $target[$key] ?? [], $sourceLang, $targetLang, $client, $apiKey);
            } elseif (is_string($value)) {
                $translated[$key] = $this->translateString($value, $sourceLang, $targetLang, $client, $apiKey);
            } elseif (is_array($value)) {
                $translated[$key] = $this->translateContent($value, $target[$key] ?? [], $sourceLang, $targetLang, $client, $apiKey);
            } else {
                $translated[$key] = $value;
            }
        }

        return $translated;
    }

    protected function translateCategories($sourceCategories, $targetCategories, $sourceLang, $targetLang, $client, $apiKey)
    {
        $translatedCategories = [];

        foreach ($sourceCategories as $categoryKey => $items) {
            // Translate 'General Information', 'Delivery', etc. (category keys)
            $translatedCategoryKey = $this->translateString($categoryKey, $sourceLang, $targetLang, $client, $apiKey);

            $translatedCategories[$translatedCategoryKey] = [];
            foreach ($items as $index => $item) {
                $translatedItem = [];

                foreach ($item as $fieldKey => $fieldValue) {
                    // Only translate values of 'question' and 'answer' keys
                    if (in_array($fieldKey, ['question', 'answer']) && is_string($fieldValue)) {
                        $translatedItem[$fieldKey] = $this->translateString($fieldValue, $sourceLang, $targetLang, $client, $apiKey);
                    } else {
                        $translatedItem[$fieldKey] = $fieldValue; // Preserve non-translatable fields
                    }
                }

                $translatedCategories[$translatedCategoryKey][] = $translatedItem;
            }
        }

        return $translatedCategories;
    }

    protected function translateString($text, $sourceLang, $targetLang, $client, $apiKey)
    {
        try {
            $response = $client->post('translate', [
                'form_params' => [
                    'auth_key' => $apiKey,
                    'text' => $text,
                    'source_lang' => strtoupper($sourceLang),
                    'target_lang' => $targetLang,
                ],
            ]);

            $responseBody = json_decode($response->getBody(), true);
            return $responseBody['translations'][0]['text'] ?? $text;
        } catch (\Exception $e) {
            $this->error("Error translating '{$text}': " . $e->getMessage());
            return $text;
        }
    }

    protected function exportArray(array $array)
    {
        $export = var_export($array, true);
        return "<?php\n\nreturn {$export};\n";
    }
}
