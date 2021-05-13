<?php

namespace EasyAliSdk\Domain\Cert;

use http\Exception\RuntimeException;
use EasyAliSdk\Util\AntCertificationUtil;

class CertEnvironment
{
    /**
     * @var
     */
    private $rootCertSN;

    /**
     * @var
     */
    private $merchantCertSN;

    /**
     * @var
     */
    private $cachedAlipayPublicKey;

    /**
     * 构造证书运行环境.
     *
     * @param $merchantCertPath    string 商户公钥证书路径
     * @param $alipayCertPath      string 支付宝公钥证书路径
     * @param $alipayRootCertPath  string 支付宝根证书路径
     */
    public function certEnvironment($merchantCertPath, $alipayCertPath, $alipayRootCertPath)
    {
        if (empty($merchantCertPath) || empty($alipayCertPath) || empty($alipayRootCertPath)) {
            throw new RuntimeException('证书参数merchantCertPath、alipayCertPath或alipayRootCertPath设置不完整。');
        }
        $antCertificationUtil        = new AntCertificationUtil();
        $this->rootCertSN            = $antCertificationUtil->getRootCertSN($alipayRootCertPath);
        $this->merchantCertSN        = $antCertificationUtil->getCertSN($merchantCertPath);
        $this->cachedAlipayPublicKey = $antCertificationUtil->getPublicKey($alipayCertPath);
    }

    /**
     * @return mixed
     */
    public function getRootCertSN()
    {
        return $this->rootCertSN;
    }

    /**
     * @return mixed
     */
    public function getMerchantCertSN()
    {
        return $this->merchantCertSN;
    }

    /**
     * @return mixed
     */
    public function getCachedAlipayPublicKey()
    {
        return $this->cachedAlipayPublicKey;
    }
}
