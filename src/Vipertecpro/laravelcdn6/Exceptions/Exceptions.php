<?php

namespace Vipertecpro\laravelcdn6\Exceptions;

/**
 * @author Vipul Walia <vipertecpro@gmail.com>
 */
class CdnException extends \RuntimeException
{
}

class MissingConfigurationFileException extends CdnException
{
}

class MissingConfigurationException extends CdnException
{
}

class UnsupportedProviderException extends CdnException
{
}

class EmptyPathException extends CdnException
{
}
