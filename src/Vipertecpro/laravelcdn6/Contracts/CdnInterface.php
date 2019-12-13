<?php

namespace Vipertecpro\laravelcdn6\Contracts;

/**
 * Interface CdnInterface.
 *
 * @author   Mahmoud Zalt <mahmoud@vinelab.com>
 */
interface CdnInterface
{
    public function push();

    public function emptyBucket();
}
