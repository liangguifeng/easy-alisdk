<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class AlipayTradeRefundResponse extends Model
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
     * @var string
     */
    public $buyerLogonId;

    /**
     * @var string
     */
    public $fundChange;

    /**
     * @var string
     */
    public $refundFee;

    /**
     * @var string
     */
    public $refundCurrency;

    /**
     * @var string
     */
    public $gmtRefundPay;

    /**
     * @var TradeFundBill[]
     */
    public $refundDetailItemList;

    /**
     * @var string
     */
    public $storeName;

    /**
     * @var string
     */
    public $buyerUserId;

    /**
     * @var PresetPayToolInfo[]
     */
    public $refundPresetPaytoolList;

    /**
     * @var string
     */
    public $refundSettlementId;

    /**
     * @var string
     */
    public $presentRefundBuyerAmount;

    /**
     * @var string
     */
    public $presentRefundDiscountAmount;

    /**
     * @var string
     */
    public $presentRefundMdiscountAmount;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'                     => 'http_body',
        'code'                         => 'code',
        'msg'                          => 'msg',
        'subCode'                      => 'sub_code',
        'subMsg'                       => 'sub_msg',
        'tradeNo'                      => 'trade_no',
        'outTradeNo'                   => 'out_trade_no',
        'buyerLogonId'                 => 'buyer_logon_id',
        'fundChange'                   => 'fund_change',
        'refundFee'                    => 'refund_fee',
        'refundCurrency'               => 'refund_currency',
        'gmtRefundPay'                 => 'gmt_refund_pay',
        'refundDetailItemList'         => 'refund_detail_item_list',
        'storeName'                    => 'store_name',
        'buyerUserId'                  => 'buyer_user_id',
        'refundPresetPaytoolList'      => 'refund_preset_paytool_list',
        'refundSettlementId'           => 'refund_settlement_id',
        'presentRefundBuyerAmount'     => 'present_refund_buyer_amount',
        'presentRefundDiscountAmount'  => 'present_refund_discount_amount',
        'presentRefundMdiscountAmount' => 'present_refund_mdiscount_amount',
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
        Model::validateRequired('buyerLogonId', $this->buyerLogonId, true);
        Model::validateRequired('fundChange', $this->fundChange, true);
        Model::validateRequired('refundFee', $this->refundFee, true);
        Model::validateRequired('refundCurrency', $this->refundCurrency, true);
        Model::validateRequired('gmtRefundPay', $this->gmtRefundPay, true);
        Model::validateRequired('refundDetailItemList', $this->refundDetailItemList, true);
        Model::validateRequired('storeName', $this->storeName, true);
        Model::validateRequired('buyerUserId', $this->buyerUserId, true);
        Model::validateRequired('refundPresetPaytoolList', $this->refundPresetPaytoolList, true);
        Model::validateRequired('refundSettlementId', $this->refundSettlementId, true);
        Model::validateRequired('presentRefundBuyerAmount', $this->presentRefundBuyerAmount, true);
        Model::validateRequired('presentRefundDiscountAmount', $this->presentRefundDiscountAmount, true);
        Model::validateRequired('presentRefundMdiscountAmount', $this->presentRefundMdiscountAmount, true);
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

        if ($this->buyerLogonId !== null) {
            $res['buyer_logon_id'] = $this->buyerLogonId;
        }

        if ($this->fundChange !== null) {
            $res['fund_change'] = $this->fundChange;
        }

        if ($this->refundFee !== null) {
            $res['refund_fee'] = $this->refundFee;
        }

        if ($this->refundCurrency !== null) {
            $res['refund_currency'] = $this->refundCurrency;
        }

        if ($this->gmtRefundPay !== null) {
            $res['gmt_refund_pay'] = $this->gmtRefundPay;
        }

        if ($this->refundDetailItemList !== null) {
            $res['refund_detail_item_list'] = [];

            if ($this->refundDetailItemList !== null && is_array($this->refundDetailItemList)) {
                $n = 0;
                foreach ($this->refundDetailItemList as $item) {
                    $res['refund_detail_item_list'][$n++] = $item !== null ? $item->toMap() : $item;
                }
            }
        }

        if ($this->storeName !== null) {
            $res['store_name'] = $this->storeName;
        }

        if ($this->buyerUserId !== null) {
            $res['buyer_user_id'] = $this->buyerUserId;
        }

        if ($this->refundPresetPaytoolList !== null) {
            $res['refund_preset_paytool_list'] = [];

            if ($this->refundPresetPaytoolList !== null && is_array($this->refundPresetPaytoolList)) {
                $n = 0;
                foreach ($this->refundPresetPaytoolList as $item) {
                    $res['refund_preset_paytool_list'][$n++] = $item !== null ? $item->toMap() : $item;
                }
            }
        }

        if ($this->refundSettlementId !== null) {
            $res['refund_settlement_id'] = $this->refundSettlementId;
        }

        if ($this->presentRefundBuyerAmount !== null) {
            $res['present_refund_buyer_amount'] = $this->presentRefundBuyerAmount;
        }

        if ($this->presentRefundDiscountAmount !== null) {
            $res['present_refund_discount_amount'] = $this->presentRefundDiscountAmount;
        }

        if ($this->presentRefundMdiscountAmount !== null) {
            $res['present_refund_mdiscount_amount'] = $this->presentRefundMdiscountAmount;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayTradeRefundResponse
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

        if (isset($map['buyer_logon_id'])) {
            $model->buyerLogonId = $map['buyer_logon_id'];
        }

        if (isset($map['fund_change'])) {
            $model->fundChange = $map['fund_change'];
        }

        if (isset($map['refund_fee'])) {
            $model->refundFee = $map['refund_fee'];
        }

        if (isset($map['refund_currency'])) {
            $model->refundCurrency = $map['refund_currency'];
        }

        if (isset($map['gmt_refund_pay'])) {
            $model->gmtRefundPay = $map['gmt_refund_pay'];
        }

        if (isset($map['refund_detail_item_list'])) {
            if (!empty($map['refund_detail_item_list'])) {
                $model->refundDetailItemList = [];
                $n                           = 0;
                foreach ($map['refund_detail_item_list'] as $item) {
                    $model->refundDetailItemList[$n++] = $item !== null ? TradeFundBill::fromMap($item) : $item;
                }
            }
        }

        if (isset($map['store_name'])) {
            $model->storeName = $map['store_name'];
        }

        if (isset($map['buyer_user_id'])) {
            $model->buyerUserId = $map['buyer_user_id'];
        }

        if (isset($map['refund_preset_paytool_list'])) {
            if (!empty($map['refund_preset_paytool_list'])) {
                $model->refundPresetPaytoolList = [];
                $n                              = 0;
                foreach ($map['refund_preset_paytool_list'] as $item) {
                    $model->refundPresetPaytoolList[$n++] = $item !== null ? PresetPayToolInfo::fromMap($item) : $item;
                }
            }
        }

        if (isset($map['refund_settlement_id'])) {
            $model->refundSettlementId = $map['refund_settlement_id'];
        }

        if (isset($map['present_refund_buyer_amount'])) {
            $model->presentRefundBuyerAmount = $map['present_refund_buyer_amount'];
        }

        if (isset($map['present_refund_discount_amount'])) {
            $model->presentRefundDiscountAmount = $map['present_refund_discount_amount'];
        }

        if (isset($map['present_refund_mdiscount_amount'])) {
            $model->presentRefundMdiscountAmount = $map['present_refund_mdiscount_amount'];
        }

        return $model;
    }
}
