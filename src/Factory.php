<?php

namespace EasyAliSdk;

use EasyAliSdk\Domain\Base\Base;
use EasyAliSdk\Domain\Util\Util;
use EasyAliSdk\Domain\Member\Member;
use EasyAliSdk\Domain\Payment\Payment;
use EasyAliSdk\Domain\Security\Security;
use EasyAliSdk\Domain\Marketing\Marketing;
use EasyAliSdk\Domain\Cert\CertEnvironment;

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

    /**
     * @param $config
     *
     * @return Factory
     */
    public static function setOptions($config)
    {
        if (!(self::$instance instanceof self)) {
            self::$instance = new self($config);
        }

        return self::$instance;
    }

    /**
     * @return mixed
     */
    private function __clone()
    {
        return clone self::$instance;
    }

    /**
     * @return Base
     */
    public static function base()
    {
        return self::$base;
    }

    /**
     * @return Marketing
     */
    public static function marketing()
    {
        return self::$marketing;
    }

    /**
     * @return Member
     */
    public static function member()
    {
        return self::$member;
    }

    /**
     * @return Payment
     */
    public static function payment()
    {
        return self::$payment;
    }

    /**
     * @return Security
     */
    public static function security()
    {
        return self::$security;
    }

    /**
     * @return Util
     */
    public static function util()
    {
        return self::$util;
    }
}
