<?php

namespace Vipertecpro\laravelcdn6\Providers;

use Vipertecpro\laravelcdn6\Providers\Contracts\ProviderInterface;

/**
 * Class Provider.
 *
 * @category Drivers Abstract Class
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
abstract class Provider implements ProviderInterface
{
    /**
     * @var string
     */
    protected $key;

    /**
     * @var string
     */
    protected $secret;

    /**
     * @var string
     */
    protected $region;

    /**
     * @var string
     */
    protected $version;

    /**
     * @var string
     */
    protected $url;

    /**
     * @var Instance of the console object
     */
    public $console;

    abstract public function upload($assets);
}
