<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;

class LocaleMiddleware
{
    // List of supported locales
    protected $supportedLocales = ['en', 'dk', 'ge', 'se', 'fr', 'it', 'pl'];

    // Map browser locale codes to supported locale codes
    protected $localeMappings = [
        'da' => 'dk', // Map 'da' (browser code) to 'dk'
        'de' => 'ge', // Map 'de' (browser code) to 'ge'
        'sv' => 'se', // Map 'sv' (browser code) to 'se'
        'fr' => 'fr', // No change for French
        'it' => 'it', // Map 'it' (browser code) to 'it'
        'pl' => 'pl', // Map 'pl' (browser code) to 'pl'
    ];

    public function handle($request, Closure $next)
    {
        // Check if the locale is already set in the session
        $locale = Session::get('locale');

        if (!$locale) {
            // Get the browser's preferred language
            $browserLocale = substr($request->server('HTTP_ACCEPT_LANGUAGE'), 0, 2);

            // Map the browser locale to your supported locale if a mapping exists
            $locale = $this->localeMappings[$browserLocale] ?? $browserLocale;

            // Validate against supported locales
            $locale = in_array($locale, $this->supportedLocales) ? $locale : 'en';

            // Store the detected locale in the session
            Session::put('locale', $locale);
        }

        // Set the application locale
        App::setLocale($locale);

        return $next($request);
    }
}
