<?php

namespace Vipertecpro\laravelcdn6\Contracts;

/**
 * Interface FinderInterface.
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
interface FinderInterface
{
    public function read(AssetInterface $paths);
}
