<?php

namespace RedCode\LinkedIn;

use Doctrine\Common\Cache\CacheProvider;
use LinkedIn\LinkedIn as LinkedInAPI;

/**
 * @author maZahaca
 */ 
class LinkedIn extends LinkedInAPI
{
    private $cacheProvider;
    private $cacheLifeTime;

    /**
     * @param array $config
     * @param CacheProvider|null $cacheProvider
     * @param int|null $cacheLifeTime
     */
    public function __construct($config, $cacheProvider = null, $cacheLifeTime = null)
    {
        $this->cacheProvider    = $cacheProvider;
        $this->cacheLifeTime    = (int)$cacheLifeTime;

        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function get($endpoint, array $payload = array())
    {
        $response = null;
        if($this->cacheProvider && $this->cacheProvider->contains($this->getCacheKey($endpoint, $payload))) {
            $response = $this->cacheProvider->fetch($this->getCacheKey($endpoint, $payload));
        }
        if(!$response) {
            $response = parent::get($endpoint, $payload);
            if($this->cacheProvider) {
                $this->cacheProvider->save($this->getCacheKey($endpoint, $payload), $response, $this->cacheLifeTime);
            }
        }
        return $response;
    }

    public function getCacheKey($endpoint, $payload)
    {
        return md5($this->getAccessToken() . $endpoint . implode('', $payload));
    }
}