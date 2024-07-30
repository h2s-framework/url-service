<?php

namespace Siarko\UrlService;

class UrlInfo
{

    protected ?string $scheme = null;
    protected ?string $host = null;
    protected ?string $port = null;
    protected ?string $user = null;
    protected ?string $pass = null;
    protected ?string $path = null;
    protected ?string $query = null;
    protected ?string $fragment = null;


    public function parse(string $url): UrlInfo
    {
        return (new UrlInfo())->setData(parse_url($url));
    }

    protected function setData(array $data): static
    {
        foreach ($data as $key => $value) {
            if(property_exists($this, $key)){
                $this->$key = $value;
            }
        }
        return $this;
    }

    /**
     * @return string|null
     */
    public function getScheme(): ?string
    {
        return $this->scheme;
    }

    /**
     * @return string|null
     */
    public function getHost(): ?string
    {
        return $this->host;
    }

    /**
     * @return string|null
     */
    public function getPort(): ?string
    {
        return $this->port;
    }

    /**
     * @return string|null
     */
    public function getUser(): ?string
    {
        return $this->user;
    }

    /**
     * @return string|null
     */
    public function getPass(): ?string
    {
        return $this->pass;
    }

    /**
     * @return string|null
     */
    public function getPath(): ?string
    {
        return $this->path;
    }

    /**
     * @return string|null
     */
    public function getQuery(): ?string
    {
        return $this->query;
    }

    /**
     * @return string|null
     */
    public function getFragment(): ?string
    {
        return $this->fragment;
    }

}