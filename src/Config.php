<?php

namespace EasyAliSdk;

use AlibabaCloud\Tea\Model;

class Config extends Model
{
    /**
     * @var
     */
    public $protocol;

    /**
     * @var
     */
    public $gatewayHost;

    /**
     * @var
     */
    public $appId;

    /**
     * @var
     */
    public $signType;

    /**
     * @var
     */
    public $alipayPublicKey;

    /**
     * @var
     */
    public $merchantPrivateKey;

    /**
     * @var
     */
    public $merchantCertPath;

    /**
     * @var
     */
    public $alipayCertPath;

    /**
     * @var
     */
    public $alipayRootCertPath;

    /**
     * @var
     */
    public $merchantCertSN;

    /**
     * @var
     */
    public $alipayCertSN;

    /**
     * @var
     */
    public $alipayRootCertSN;

    /**
     * @var
     */
    public $notifyUrl;

    /**
     * @var
     */
    public $encryptKey;

    /**
     * @var
     */
    public $httpProxy;

    /**
     * @var
     */
    public $ignoreSSL;
}
