<?php

namespace Siarko\UrlService;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\Paths\RootPath;
use Siarko\Utils\Strings;

class UrlProvider
{

    public const REQUEST_SCHEME = 'REQUEST_SCHEME';

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
        return rtrim($domain, UrlUtils::URL_SEPARATOR).
            UrlUtils::URL_SEPARATOR.
            ltrim($this->getProjectBaseUrl(), UrlUtils::URL_SEPARATOR);
    }

    /**
     * @param array|string $urls
     * @return string
     * @throws RootPathNotSet
     */
    public function getSubUrl(array|string $urls): string
    {
        $urls = is_array($urls) ? $urls : [$urls];
        return UrlUtils::implode([$this->getBaseUrl(), ...$urls]);
    }

    /**
     * @return string
     * @throws RootPathNotSet
     */
    public function getCurrentUrl(): string
    {
        return UrlUtils::implode([$this->getBaseUrl(), $this->getSuffix()]);
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
        $subFolder = UrlUtils::explode(dirname($_SERVER['SCRIPT_NAME']));
        $projectRoot = UrlUtils::explode($this->rootPath->get(false));

        return UrlUtils::URL_SEPARATOR.implode(UrlUtils::URL_SEPARATOR, array_intersect($subFolder, $projectRoot));
    }



}