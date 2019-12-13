<?php

namespace Vipertecpro\laravelcdn6\Contracts;

/**
 * Interface CdnInterface.
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
interface CdnInterface
{
    public function push();

    public function emptyBucket();
}
