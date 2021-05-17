<?php

namespace EasyAliSdk\Domain\Security;

use EasyAliSdk\Domain\AliSdkOperate;
use EasyAliSdk\Domain\Security\TextRisk\Client as textRiskClient;

class Security implements AliSdkOperate
{
    /**
     * @var
     */
    private $kernel;

    /**
     * Security constructor.
     *
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return textRiskClient
     */
    public function textRisk()
    {
        return new textRiskClient($this->kernel);
    }
}
