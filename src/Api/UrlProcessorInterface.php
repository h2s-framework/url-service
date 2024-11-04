<?php

namespace Siarko\UrlService\Api;

use Siarko\UrlService\Processor\ProcessedUrl;

interface UrlProcessorInterface
{

    /**
     * @param ProcessedUrl $url
     * @return ProcessedUrl
     */
    public function processRelativeUrl(ProcessedUrl $url): ProcessedUrl;

}