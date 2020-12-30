<?php

namespace Sevming\TencentMap\Providers;

use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * {@inheritDoc}
     *
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app['client'] = function ($app) {
            return new Client($app);
        };
    }
}