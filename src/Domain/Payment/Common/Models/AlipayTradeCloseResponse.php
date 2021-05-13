<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class AlipayTradeCloseResponse extends Model
{
    /**
     * @description 响应原始字符串
     *
     * @var string
     */
    public $httpBody;

    /**
     * @var string
     */
    public $code;

    /**
     * @var string
     */
    public $msg;

    /**
     * @var string
     */
    public $subCode;

    /**
     * @var string
     */
    public $subMsg;

    /**
     * @var string
     */
    public $tradeNo;

    /**
     * @var string
     */
    public $outTradeNo;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'   => 'http_body',
        'code'       => 'code',
        'msg'        => 'msg',
        'subCode'    => 'sub_code',
        'subMsg'     => 'sub_msg',
        'tradeNo'    => 'trade_no',
        'outTradeNo' => 'out_trade_no',
    ];

    public function validate()
    {
        Model::validateRequired('httpBody', $this->httpBody, true);
        Model::validateRequired('code', $this->code, true);
        Model::validateRequired('msg', $this->msg, true);
        Model::validateRequired('subCode', $this->subCode, true);
        Model::validateRequired('subMsg', $this->subMsg, true);
        Model::validateRequired('tradeNo', $this->tradeNo, true);
        Model::validateRequired('outTradeNo', $this->outTradeNo, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->httpBody !== null) {
            $res['http_body'] = $this->httpBody;
        }

        if ($this->code !== null) {
            $res['code'] = $this->code;
        }

        if ($this->msg !== null) {
            $res['msg'] = $this->msg;
        }

        if ($this->subCode !== null) {
            $res['sub_code'] = $this->subCode;
        }

        if ($this->subMsg !== null) {
            $res['sub_msg'] = $this->subMsg;
        }

        if ($this->tradeNo !== null) {
            $res['trade_no'] = $this->tradeNo;
        }

        if ($this->outTradeNo !== null) {
            $res['out_trade_no'] = $this->outTradeNo;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayTradeCloseResponse
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['http_body'])) {
            $model->httpBody = $map['http_body'];
        }

        if (isset($map['code'])) {
            $model->code = $map['code'];
        }

        if (isset($map['msg'])) {
            $model->msg = $map['msg'];
        }

        if (isset($map['sub_code'])) {
            $model->subCode = $map['sub_code'];
        }

        if (isset($map['sub_msg'])) {
            $model->subMsg = $map['sub_msg'];
        }

        if (isset($map['trade_no'])) {
            $model->tradeNo = $map['trade_no'];
        }

        if (isset($map['out_trade_no'])) {
            $model->outTradeNo = $map['out_trade_no'];
        }

        return $model;
    }
}
