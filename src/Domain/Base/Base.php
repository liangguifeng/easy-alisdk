<?php

namespace EasyAliSdk\Domain\Base;

use EasyAliSdk\Domain\AliSdkOperate;
use Alipay\EasySDK\Base\Image\Client as imageClient;
use Alipay\EasySDK\Base\OAuth\Client as oauthClient;
use Alipay\EasySDK\Base\Video\Client as videoClient;
use Alipay\EasySDK\Base\Qrcode\Client as qrcodeClient;

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
