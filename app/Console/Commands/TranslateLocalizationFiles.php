<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;
use GuzzleHttp\Client;

class TranslateLocalizationFiles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'localization:translate';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Translate JSON localization files using DeepL API and maintain formatting';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $sourceLang = 'en'; // Source language code
        $deeplApiKey = env('DEEPL_TRANSLATE'); // Fetching the DeepL API key from .env

        if (!$deeplApiKey) {
            $this->error('DeepL API key not found in .env file. Please set the DEEPL_TRANSLATE variable.');
            return Command::FAILURE;
        }

        // Define the target languages and their corresponding DeepL language codes
        $targetLangs = [
            'dk' => 'DA', // Danish
            'fr' => 'FR', // French
            'se' => 'SV', // Swedish
            'ge' => 'DE', // German
            'it' => 'IT', // Italian
            'pl' => 'PL', // Polish
        ];

        // Path to the source file
        $sourceFilePath = base_path("lang/{$sourceLang}.json");

        if (!File::exists($sourceFilePath)) {
            $this->error("Source file not found at: {$sourceFilePath}");
            return Command::FAILURE;
        }

        $sourceContent = json_decode(File::get($sourceFilePath), true);

        if (empty($sourceContent)) {
            $this->error("Source file {$sourceLang}.json is empty or invalid.");
            return Command::FAILURE;
        }

        $client = new Client([
            'base_uri' => 'https://api-free.deepl.com/v2/',
        ]);

        // Define a regex pattern to detect all-uppercase shortcuts
        $shortcutPattern = '/^[A-Z]{2,}$/';

        foreach ($targetLangs as $langFile => $langCode) {
            $this->info("Processing translations for {$langFile} ({$langCode})...");

            $targetFilePath = base_path("lang/{$langFile}.json");
            $targetContent = File::exists($targetFilePath)
                ? json_decode(File::get($targetFilePath), true)
                : [];

            if (is_null($targetContent)) {
                $targetContent = [];
            }

            foreach ($sourceContent as $key => $text) {
                // Skip comments
                if (str_starts_with($key, "//")) {
                    $targetContent[$key] = $text;
                    continue;
                }

                // If the key already exists in the target and is not empty, skip translation
                if (isset($targetContent[$key]) && !empty($targetContent[$key])) {
                    continue;
                }

                // Check if the text matches the shortcut pattern (e.g., "FAQ")
                if (preg_match($shortcutPattern, $text)) {
                    $targetContent[$key] = $text; // Preserve as-is
                    $this->info("Preserved shortcut '{$text}' for '{$langFile}'.");
                    continue;
                }

                try {
                    // Translate using DeepL API
                    $response = $client->post('translate', [
                        'form_params' => [
                            'auth_key' => $deeplApiKey,
                            'text' => $text,
                            'source_lang' => strtoupper($sourceLang),
                            'target_lang' => $langCode,
                        ],
                    ]);

                    $responseBody = json_decode($response->getBody(), true);

                    if (!empty($responseBody['translations'][0]['text'])) {
                        $targetContent[$key] = $responseBody['translations'][0]['text'];
                        $this->info("Translated '{$key}' to '{$langFile}': {$targetContent[$key]}");
                    } else {
                        $this->error("Translation failed for '{$key}' to '{$langFile}', using English fallback.");
                        $targetContent[$key] = $text;
                    }
                } catch (\Exception $e) {
                    $this->error("Error translating key '{$key}' to '{$langFile}': " . $e->getMessage());
                    $targetContent[$key] = $text;
                }
            }

            // Save the updated JSON content with proper formatting
            $formattedContent = json_encode($targetContent, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE);
            File::put($targetFilePath, $formattedContent);

            $this->info("Translation for {$langFile} completed and saved.");
        }

        $this->info("All translations are up to date!");
        return Command::SUCCESS;
    }
}
