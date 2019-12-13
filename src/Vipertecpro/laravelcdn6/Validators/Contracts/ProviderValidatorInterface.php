<?php

namespace Vipertecpro\laravelcdn6\Validators\Contracts;

/**
 * Interface ProviderValidatorInterface.
 *
 * @author  Vipul Walia <vipertecpro@gmail.com>
 */
interface ProviderValidatorInterface
{
    public function validate($configuration, $required);
}
