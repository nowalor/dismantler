<?php

return [

    'key' => env('DEEPL_API_KEY', null),

    'base_url' => env('DEEPL_API_BASE_URL', 'https://api-free.deepl.com/v2/'),

    'source_language' => env('DEEPL_SOURCE_LANG', 'en'),
    'target_languages' => [
        'dk' => 'DA', // Danish
        'fr' => 'FR', // French
        'se' => 'SV', // Swedish
        'ge' => 'DE', // German
        'it' => 'IT', // Italian
        'pl' => 'PL', // Polish
    ],

];
