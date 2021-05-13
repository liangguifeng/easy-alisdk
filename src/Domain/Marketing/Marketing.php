<?php

namespace EasyAliSdk\Domain\Marketing;

use EasyAliSdk\Domain\AliSdkOperate;
use Alipay\EasySDK\Marketing\Pass\Client as passClient;
use Alipay\EasySDK\Marketing\OpenLife\Client as openLifeClient;
use Alipay\EasySDK\Marketing\TemplateMessage\Client as templateMessageClient;

class Marketing implements AliSdkOperate
{
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function openLife()
    {
        return new openLifeClient($this->kernel);
    }

    public function pass()
    {
        return new passClient($this->kernel);
    }

    public function templateMessage()
    {
        return new templateMessageClient($this->kernel);
    }
}
