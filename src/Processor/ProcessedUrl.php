<?php

namespace Siarko\UrlService\Processor;

use Siarko\UrlService\UrlUtils;

class ProcessedUrl
{

    /**
     * @param string $relativeUrl
     * @param string $baseUrl
     */
    public function __construct(
        private string $relativeUrl,
        private string $baseUrl
    )
    {
    }

    /**
     * @return string
     */
    public function getRelativeUrl(): string
    {
        return $this->relativeUrl;
    }

    /**
     * @param string $relativeUrl
     * @return void
     */
    public function setRelativeUrl(string $relativeUrl): void
    {
        $this->relativeUrl = $relativeUrl;
    }

    /**
     * @return string
     */
    public function getBaseUrl(): string
    {
        return $this->baseUrl;
    }

    /**
     * @param string $baseUrl
     * @return void
     */
    public function setBaseUrl(string $baseUrl): void
    {
        $this->baseUrl = $baseUrl;
    }

    /**
     * @return string
     */
    public function construct(): string
    {
        return UrlUtils::implode([$this->baseUrl, $this->relativeUrl]);
    }
}