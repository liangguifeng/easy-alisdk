<?php

namespace EasyAliSdk\Domain\Util;

use EasyAliSdk\Domain\AliSdkOperate;
use Alipay\EasySDK\Util\AES\Client as aesClient;
use Alipay\EasySDK\Util\Generic\Client as genericClient;

class Util implements AliSdkOperate
{
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function generic()
    {
        return new genericClient($this->kernel);
    }

    public function aes()
    {
        return new aesClient($this->kernel);
    }
}
