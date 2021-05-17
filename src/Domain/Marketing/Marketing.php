<?php

namespace EasyAliSdk\Domain\Marketing;

use EasyAliSdk\Domain\AliSdkOperate;
use EasyAliSdk\Domain\Marketing\Pass\Client as passClient;
use EasyAliSdk\Domain\Marketing\OpenLife\Client as openLifeClient;
use EasyAliSdk\Domain\Marketing\TemplateMessage\Client as templateMessageClient;
use EasyAliSdk\Domain\Marketing\Card\Client as cardClient;

class Marketing implements AliSdkOperate
{
    /**
     * @var
     */
    private $kernel;

    /**
     * Marketing constructor.
     *
     * @param $kernel
     */
    public function __construct($kernel)
    {
        $this->kernel = $kernel;
    }

    /**
     * @return openLifeClient
     */
    public function openLife()
    {
        return new openLifeClient($this->kernel);
    }

    /**
     * @return passClient
     */
    public function pass()
    {
        return new passClient($this->kernel);
    }

    /**
     * @return templateMessageClient
     */
    public function templateMessage()
    {
        return new templateMessageClient($this->kernel);
    }

    /**
     * @return cardClient
     */
    public function card()
    {
        return new cardClient($this->kernel);
    }
}
