<?php

namespace EasyAliSdk;

use EasyAliSdk\Domain\Base\Base;
use EasyAliSdk\Domain\Member\Member;
use EasyAliSdk\Domain\Cert\CertEnvironment;
use Alipay\EasySDK\Util\AES\Client as aesClient;
use Alipay\EasySDK\Payment\App\Client as appClient;
use Alipay\EasySDK\Payment\Wap\Client as wapClient;
use Alipay\EasySDK\Payment\Page\Client as pageClient;
use Alipay\EasySDK\Marketing\Pass\Client as passClient;
use Alipay\EasySDK\Util\Generic\Client as genericClient;
use Alipay\EasySDK\Payment\Common\Client as commonClient;
use Alipay\EasySDK\Payment\Huabei\Client as huabeiClient;
use Alipay\EasySDK\Security\TextRisk\Client as textRiskClient;
use Alipay\EasySDK\Marketing\OpenLife\Client as openLifeClient;
use Alipay\EasySDK\Payment\FaceToFace\Client as faceToFaceClient;
use Alipay\EasySDK\Marketing\TemplateMessage\Client as templateMessageClient;

class Factory
{
    /**
     * @var
     */
    public $config;

    /**
     * @var
     */
    public $kernel;

    /**
     * @var
     */
    private static $instance;

    /**
     * @var Base
     */
    protected static $base;

    /**
     * @var Marketing
     */
    protected static $marketing;

    /**
     * @var Member
     */
    protected static $member;

    /**
     * @var Payment
     */
    protected static $payment;

    /**
     * @var Security
     */
    protected static $security;

    /**
     * @var Util
     */
    protected static $util;

    /**
     * Factory constructor.
     *
     * @param $config
     */
    private function __construct($config)
    {
        if (!empty($config->alipayCertPath)) {
            $certEnvironment = new CertEnvironment();
            $certEnvironment->certEnvironment(
                $config->merchantCertPath,
                $config->alipayCertPath,
                $config->alipayRootCertPath
            );
            $config->merchantCertSN   = $certEnvironment->getMerchantCertSN();
            $config->alipayRootCertSN = $certEnvironment->getRootCertSN();
            $config->alipayPublicKey  = $certEnvironment->getCachedAlipayPublicKey();
        }

        $kernel          = new EasySDKKernel($config);
        self::$base      = new Base($kernel);
        self::$marketing = new Marketing($kernel);
        self::$member    = new Member($kernel);
        self::$payment   = new Payment($kernel);
        self::$security  = new Security($kernel);
        self::$util      = new Util($kernel);
    }

    public static function setOptions($config)
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    private function __clone()
    {
    }

    public static function base()
    {
        return self::$base;
    }

    public static function marketing()
    {
        return self::$marketing;
    }

    public static function member()
    {
        return self::$member;
    }

    public static function payment()
    {
        return self::$payment;
    }

    public static function security()
    {
        return self::$security;
    }

    public static function util()
    {
        return self::$util;
    }
}








