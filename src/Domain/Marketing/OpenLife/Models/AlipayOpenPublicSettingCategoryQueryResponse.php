<?php

namespace EasyAliSdk\Domain\Marketing\OpenLife\Models;

use AlibabaCloud\Tea\Model;

class AlipayOpenPublicSettingCategoryQueryResponse extends Model
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
    public $primaryCategory;

    /**
     * @var string
     */
    public $secondaryCategory;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'          => 'http_body',
        'code'              => 'code',
        'msg'               => 'msg',
        'subCode'           => 'sub_code',
        'subMsg'            => 'sub_msg',
        'primaryCategory'   => 'primary_category',
        'secondaryCategory' => 'secondary_category',
    ];

    public function validate()
    {
        Model::validateRequired('httpBody', $this->httpBody, true);
        Model::validateRequired('code', $this->code, true);
        Model::validateRequired('msg', $this->msg, true);
        Model::validateRequired('subCode', $this->subCode, true);
        Model::validateRequired('subMsg', $this->subMsg, true);
        Model::validateRequired('primaryCategory', $this->primaryCategory, true);
        Model::validateRequired('secondaryCategory', $this->secondaryCategory, true);
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

        if ($this->primaryCategory !== null) {
            $res['primary_category'] = $this->primaryCategory;
        }

        if ($this->secondaryCategory !== null) {
            $res['secondary_category'] = $this->secondaryCategory;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipayOpenPublicSettingCategoryQueryResponse
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

        if (isset($map['primary_category'])) {
            $model->primaryCategory = $map['primary_category'];
        }

        if (isset($map['secondary_category'])) {
            $model->secondaryCategory = $map['secondary_category'];
        }

        return $model;
    }
}
