<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class TradeFundBill extends Model
{
    /**
     * @var string
     */
    public $fundChannel;

    /**
     * @var string
     */
    public $bankCode;

    /**
     * @var string
     */
    public $amount;

    /**
     * @var string
     */
    public $realAmount;

    /**
     * @var string
     */
    public $fundType;

    /**
     * @var string[]
     */
    protected $_name = [
        'fundChannel' => 'fund_channel',
        'bankCode'    => 'bank_code',
        'amount'      => 'amount',
        'realAmount'  => 'real_amount',
        'fundType'    => 'fund_type',
    ];

    public function validate()
    {
        Model::validateRequired('fundChannel', $this->fundChannel, true);
        Model::validateRequired('bankCode', $this->bankCode, true);
        Model::validateRequired('amount', $this->amount, true);
        Model::validateRequired('realAmount', $this->realAmount, true);
        Model::validateRequired('fundType', $this->fundType, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->fundChannel !== null) {
            $res['fund_channel'] = $this->fundChannel;
        }

        if ($this->bankCode !== null) {
            $res['bank_code'] = $this->bankCode;
        }

        if ($this->amount !== null) {
            $res['amount'] = $this->amount;
        }

        if ($this->realAmount !== null) {
            $res['real_amount'] = $this->realAmount;
        }

        if ($this->fundType !== null) {
            $res['fund_type'] = $this->fundType;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return TradeFundBill
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['fund_channel'])) {
            $model->fundChannel = $map['fund_channel'];
        }

        if (isset($map['bank_code'])) {
            $model->bankCode = $map['bank_code'];
        }

        if (isset($map['amount'])) {
            $model->amount = $map['amount'];
        }

        if (isset($map['real_amount'])) {
            $model->realAmount = $map['real_amount'];
        }

        if (isset($map['fund_type'])) {
            $model->fundType = $map['fund_type'];
        }

        return $model;
    }
}
