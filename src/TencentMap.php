<?php

namespace Sevming\TencentMap;

use GuzzleHttp\Exception\GuzzleException;
use Sevming\Foundation\Exceptions\Exception AS FoundationException;
use Sevming\Foundation\Foundation;
use Sevming\TencentMap\Providers\ServiceProvider;

/**
 * Class TencentMap
 *
 * @property \Sevming\TencentMap\Providers\Client $client
 */
class TencentMap extends Foundation
{
    /**
     * @var string[]
     */
    protected $providers = [
        ServiceProvider::class
    ];

    /**
     * Constructor.
     *
     * @param array $config
     */
    public function __construct(array $config = [])
    {
        parent::__construct(array_merge([
            'http' => ['base_uri' => 'https://apis.map.qq.com/']
        ], $config));
    }

    /**
     * Get location by latitude and longitude.
     *
     * @param string $location
     * @param array  $options
     *
     * @return mixed
     * @throws GuzzleException|FoundationException
     */
    public function getLocationByLngLat(string $location, array $options = [])
    {
        $params = ['location' => $location] + $options;
        return $this->client->get('ws/geocoder/v1/?', $params);
    }

    /**
     * Get location by ip.
     *
     * @param string|null $ip
     * @param array       $options
     *
     * @return mixed
     * @throws GuzzleException|FoundationException
     */
    public function getLocationByIp(?string $ip = null, array $options = [])
    {
        $params = [];
        if (!is_null($ip)) {
            $params['ip'] = $ip;
        }

        return $this->client->get('ws/location/v1/ip?', $params + $options);
    }

}
