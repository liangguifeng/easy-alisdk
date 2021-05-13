<?php

namespace EasyAliSdk\Domain\Payment\Page\Models;

use AlibabaCloud\Tea\Model;

class AlipayTradePagePayResponse extends Model
{
    /**
     * @description 订单信息，Form表单形式
     *
     * @var string
     */
    public $body;

    /**
     * @var string[]
     */
    protected $_name = [
        'body' => 'body',
    ];

    public function validate()
    {
        Model::validateRequired('body', $this->body, true);
    }

    /**
     * @return array
     */
    public function toMap()
    {
        $res = [];

        if ($this->body !== null) {
            $res['body'] = $this->body;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayTradePagePayResponse
     */
    public static function fromMap($map = [])
    {
        $model = new self();

        if (isset($map['body'])) {
            $model->body = $map['body'];
        }

        return $model;
    }
}
