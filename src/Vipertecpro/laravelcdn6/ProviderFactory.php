<?php

namespace Vipertecpro\laravelcdn6;

use Illuminate\Support\Facades\App;
use Vipertecpro\laravelcdn6\Contracts\ProviderFactoryInterface;
use Vipertecpro\laravelcdn6\Exceptions\MissingConfigurationException;
use Vipertecpro\laravelcdn6\Exceptions\UnsupportedProviderException;

/**
 * Class ProviderFactory
 * This class is responsible of creating objects from the default
 * provider found in the config file.
 *
 * @category Factory
 *
 * @author  Mahmoud Zalt <mahmoud@vinelab.com>
 */
class ProviderFactory implements ProviderFactoryInterface
{
    const DRIVERS_NAMESPACE = 'Vipertecpro\\laravelcdn6\\Providers\\';

    /**
     * Create and return an instance of the corresponding
     * Provider concrete according to the configuration.
     *
     * @param array $configurations
     *
     * @throws \Vipertecpro\laravelcdn6\UnsupportedDriverException
     *
     * @return mixed
     */
    public function create($configurations = [])
    {
        // get the default provider name
        $provider = isset($configurations['default']) ? $configurations['default'] : null;

        if (!$provider) {
            throw new MissingConfigurationException('Missing Configurations: Default Provider');
        }

        // prepare the full driver class name
        $driver_class = self::DRIVERS_NAMESPACE.ucwords($provider).'Provider';

        if (!class_exists($driver_class)) {
            throw new UnsupportedProviderException("CDN provider ($provider) is not supported");
        }

        // initialize the driver object and initialize it with the configurations
        $driver_object = App::make($driver_class)->init($configurations);

        return $driver_object;
    }
}
