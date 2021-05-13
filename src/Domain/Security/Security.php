<?php

namespace EasyAliSdk\Domain\Security;

use EasyAliSdk\Domain\AliSdkOperate;
use Alipay\EasySDK\Security\TextRisk\Client as textRiskClient;

class Security implements AliSdkOperate
{
    private $kernel;

    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    public function textRisk()
    {
        return new textRiskClient($this->kernel);
    }
}
