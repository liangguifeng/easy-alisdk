<?php

namespace EasyAliSdk\Domain\Member\Identification\Models;

use AlibabaCloud\Tea\Model;

class AlipayUserCertifyOpenInitializeResponse extends Model
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
    public $certifyId;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'  => 'http_body',
        'code'      => 'code',
        'msg'       => 'msg',
        'subCode'   => 'sub_code',
        'subMsg'    => 'sub_msg',
        'certifyId' => 'certify_id',
    ];

    public function validate()
    {
        Model::validateRequired('httpBody', $this->httpBody, true);
        Model::validateRequired('code', $this->code, true);
        Model::validateRequired('msg', $this->msg, true);
        Model::validateRequired('subCode', $this->subCode, true);
        Model::validateRequired('subMsg', $this->subMsg, true);
        Model::validateRequired('certifyId', $this->certifyId, true);
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

        if ($this->certifyId !== null) {
            $res['certify_id'] = $this->certifyId;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayUserCertifyOpenInitializeResponse
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

        if (isset($map['certify_id'])) {
            $model->certifyId = $map['certify_id'];
        }

        return $model;
    }
}
