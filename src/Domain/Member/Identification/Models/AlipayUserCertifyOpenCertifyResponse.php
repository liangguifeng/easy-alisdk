<?php

namespace EasyAliSdk\Domain\Member\Identification\Models;

use AlibabaCloud\Tea\Model;

class AlipayUserCertifyOpenCertifyResponse extends Model
{
    /**
     * @description 认证服务请求地址
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
     * @return AlipayUserCertifyOpenCertifyResponse
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
