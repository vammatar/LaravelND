<?php

namespace App\Http\Middleware;

use App\Models\ShortCode;
use Closure;

class ReplaceShortCodes
{
    public function handle($request, Closure $next)
    {
        $response = $next($request);

        $content = $response->getContent();

        $shortCodes = ShortCode::all();

        foreach ($shortCodes as $shortCode) {
            $shortcodePattern = '/\[\[' . preg_quote($shortCode->shortcode) . '\]\]/';
            $content = preg_replace($shortcodePattern, $shortCode->replace, $content);
        }

        $response->setContent($content);

        return $response;
    }
}
