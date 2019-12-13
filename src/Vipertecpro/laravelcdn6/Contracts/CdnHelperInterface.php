<?php

namespace Vipertecpro\laravelcdn6\Contracts;

/**
 * Interface CdnHelperInterface.
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
interface CdnHelperInterface
{
    public function getConfigurations();

    public function validate($configuration, $required);

    public function parseUrl($url);

    public function startsWith($haystack, $needle);

    public function cleanPath($path);
}
