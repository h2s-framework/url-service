<?php

namespace Siarko\UrlService;

class UrlUtils
{

    public const URL_SEPARATOR = '/';

    /**
     * @param string $url
     * @return array
     */
    public static function explode(string $url): array
    {
        return explode(
            self::URL_SEPARATOR,
            trim(
                str_replace(DIRECTORY_SEPARATOR, self::URL_SEPARATOR, $url),
                self::URL_SEPARATOR
            )
        );
    }

    /**
     * @param array $parts
     * @return string
     */
    public static function implode(array $parts): string
    {
        return implode(
            self::URL_SEPARATOR,
            array_map(fn($part) => trim($part, self::URL_SEPARATOR.' '), $parts)
        );
    }

    /**
     * @param string $url
     * @param string $baseUrl
     * @return string
     */
    public static function parseRelativeUrl(string $url, string $baseUrl): string
    {
        $parts = self::explode($url);
        $result = self::explode($baseUrl);
        foreach ($parts as $part) {
            match ($part) {
                '..' => array_pop($result),
                default => $result[] = $part
            };
        }
        return self::implode($result);
    }

}