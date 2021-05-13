<?php

namespace EasyAliSdk\Domain\Base;

use EasyAliSdk\Domain\AliSdkOperate;
use EasyAliSdk\Domain\Base\Image\Client as imageClient;
use EasyAliSdk\Domain\Base\OAuth\Client as oauthClient;
use EasyAliSdk\Domain\Base\Video\Client as videoClient;
use EasyAliSdk\Domain\Base\Qrcode\Client as qrcodeClient;

class Base implements AliSdkOperate
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
     * @return imageClient
     */
    public function image()
    {
        return new imageClient($this->kernel);
    }

    /**
     * @return oauthClient
     */
    public function oauth()
    {
        return new oauthClient($this->kernel);
    }

    /**
     * @return qrcodeClient
     */
    public function qrcode()
    {
        return new qrcodeClient($this->kernel);
    }

    /**
     * @return videoClient
     */
    public function video()
    {
        return new videoClient($this->kernel);
    }
}
