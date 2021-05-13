<?php

namespace EasyAliSdk\Domain\Payment\Common\Models;

use AlibabaCloud\Tea\Model;

class PresetPayToolInfo extends Model
{
    /**
     * @var string[]
     */
    public $amount;

    /**
     * @var string
     */
    public $assertTypeCode;

    /**
     * @var string[]
     */
    protected $_name = [
        'amount'         => 'amount',
        'assertTypeCode' => 'assert_type_code',
    ];

    public function validate()
    {
        Model::validateRequired('amount', $this->amount, true);
        Model::validateRequired('assertTypeCode', $this->assertTypeCode, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->amount !== null) {
            $res['amount'] = $this->amount;
        }

        if ($this->assertTypeCode !== null) {
            $res['assert_type_code'] = $this->assertTypeCode;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return PresetPayToolInfo
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['amount'])) {
            if (!empty($map['amount'])) {
                $model->amount = $map['amount'];
            }
        }

        if (isset($map['assert_type_code'])) {
            $model->assertTypeCode = $map['assert_type_code'];
        }

        return $model;
    }
}
