<?php

namespace EasyAliSdk\Domain\Business;

use EasyAliSdk\Domain\AliSdkOperate;
use EasyAliSdk\Domain\Business\Mall\Client as mallClient;

class Business implements AliSdkOperate
{
    /**
     * @var
     */
    private $kernel;

    /**
     * Base constructor.
     *
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return mallClient
     */
    public function mall()
    {
        return new mallClient($this->kernel);
    }
}
