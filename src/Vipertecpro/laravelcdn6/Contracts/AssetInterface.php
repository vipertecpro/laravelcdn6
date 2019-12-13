<?php

namespace Vipertecpro\laravelcdn6\Contracts;

/**
 * Interface AssetInterface.
 *
 * @author   Vipul Walia <vipertecpro@gmail.com>
 */
interface AssetInterface
{
    public function init($configurations);

    public function getIncludedDirectories();

    public function getIncludedExtensions();

    public function getIncludedPatterns();

    public function getExcludedDirectories();

    public function getExcludedFiles();

    public function getExcludedExtensions();

    public function getExcludedPatterns();

    public function getExcludeHidden();

    public function getAssets();

    public function setAssets($assets);
}
