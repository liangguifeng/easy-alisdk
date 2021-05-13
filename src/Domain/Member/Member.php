<?php

namespace EasyAliSdk\Domain\Member;

use EasyAliSdk\Domain\AliSdkOperate;
use EasyAliSdk\Domain\Member\Identification\Client as identificationClient;

class Member implements AliSdkOperate
{
    /**
     * @var
     */
    private $kernel;

    /**
     * Member constructor.
     *
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return identificationClient
     */
    public function identification()
    {
        return new identificationClient($this->kernel);
    }
}
