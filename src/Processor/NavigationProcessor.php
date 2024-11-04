<?php

namespace Siarko\UrlService\Processor;

use Siarko\Paths\Exception\RootPathNotSet;
use Siarko\UrlService\Api\UrlProcessorInterface;
use Siarko\UrlService\UrlProvider;
use Siarko\UrlService\UrlUtils;

class NavigationProcessor implements UrlProcessorInterface
{

    public function __construct(
        private readonly UrlProvider $urlProvider
    )
    {
    }

    /**
     * @param ProcessedUrl $url
     * @return ProcessedUrl
     * @throws RootPathNotSet
     */
    public function processRelativeUrl(ProcessedUrl $url): ProcessedUrl
    {
        //Url Starts with / - lets make base url absolute
        if(str_starts_with($url->getRelativeUrl(), UrlUtils::URL_SEPARATOR)){
            $url->setBaseUrl($this->urlProvider->getBaseUrl());
        }

        $parts = UrlUtils::explode($url->getRelativeUrl());
        $result = UrlUtils::explode($url->getBaseUrl());
        foreach ($parts as $part) {
            if($part === '..'){
                array_pop($result);
            }
        }
        $url->setBaseUrl(UrlUtils::implode($result));
        return $url;
    }
}