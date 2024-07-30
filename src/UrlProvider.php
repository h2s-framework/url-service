<?php

namespace Siarko\UrlService;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\Paths\RootPath;
use Siarko\Utils\Strings;

class UrlProvider
{

    public const REQUEST_SCHEME = 'REQUEST_SCHEME';
    
    public const URL_SEPARATOR = '/';

    /**
     * @param RootPath $rootPath
     */
    public function __construct(
        private readonly RootPath $rootPath
    )
    {
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    public function getBaseUrl(): string
    {
        $domain = $this->getRequestScheme()."://".$_SERVER['HTTP_HOST'];
        return rtrim($domain, self::URL_SEPARATOR).
            self::URL_SEPARATOR.
            ltrim($this->getProjectBaseUrl(), self::URL_SEPARATOR);
    }

    /**
     * @param array|string $urls
     * @return string
     * @throws RootPathNotSet
     */
    public function getSubUrl(array|string $urls): string
    {
        $urls = is_array($urls) ? $urls : [$urls];
        return implode(self::URL_SEPARATOR, [$this->getBaseUrl(), ...$urls]);
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    public function getCurrentUrl(): string
    {
        return $this->getBaseUrl().$this->getSuffix();
    }

    /**
     * @return string
     */
    public function getSuffix(): string
    {
        return $_GET['_URL'];
    }

    /**
     * @return string
     */
    public function getRequestScheme(): string
    {
        if(array_key_exists(self::REQUEST_SCHEME, $_SERVER)){
            return $_SERVER[self::REQUEST_SCHEME];
        }
        return 'http';
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    protected function getProjectBaseUrl(): string
    {
        $subFolder = $this->explodeUrl(dirname($_SERVER['SCRIPT_NAME']));
        $projectRoot = $this->explodeUrl($this->rootPath->get(false));

        return self::URL_SEPARATOR.implode(self::URL_SEPARATOR, array_intersect($subFolder, $projectRoot));
    }

    /**
     * @param string $url
     * @return array
     */
    private function explodeUrl(string $url): array
    {
        return explode(
            self::URL_SEPARATOR,
            trim(
                str_replace(DIRECTORY_SEPARATOR, self::URL_SEPARATOR, $url),
                self::URL_SEPARATOR
            )
        );
    }

}