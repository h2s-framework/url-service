<?php

namespace Siarko\UrlService\Processor;

use Siarko\UrlService\Api\UrlProcessorInterface;
use Siarko\UrlService\Processor\ProcessedUrlFactory;

class UrlProcessorManager implements UrlProcessorInterface
{

    /**
     * @param ProcessedUrlFactory $processedUrlFactory
     * @param UrlProcessorInterface[] $processors
     */
    public function __construct(
        private readonly ProcessedUrlFactory $processedUrlFactory,
        private readonly array $processors = []
    )
    {
    }

    /**
     * @param ProcessedUrl $url
     * @return ProcessedUrl
     */
    public function processRelativeUrl(ProcessedUrl $url): ProcessedUrl
    {
        foreach ($this->processors as $processor) {
            $url = $processor->processRelativeUrl($url);
        }
        return $url;
    }

    /**
     * @param string $url
     * @param string $base
     * @return string
     */
    public function process(string $url, string $base): string
    {
        return $this->processRelativeUrl(
            $this->processedUrlFactory->createNamed(relativeUrl: $url, baseUrl: $base)
        )->construct();
    }
}