<?php

namespace EasyAliSdk\Domain\Base\OAuth\Models;

use AlibabaCloud\Tea\Model;

class AlipaySystemOauthTokenResponse extends Model
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
    public $userId;

    /**
     * @var string
     */
    public $accessToken;

    /**
     * @var int
     */
    public $expiresIn;

    /**
     * @var string
     */
    public $refreshToken;

    /**
     * @var int
     */
    public $reExpiresIn;

    /**
     * @var string[]
     */
    protected $_name = [
        'httpBody'     => 'http_body',
        'code'         => 'code',
        'msg'          => 'msg',
        'subCode'      => 'sub_code',
        'subMsg'       => 'sub_msg',
        'userId'       => 'user_id',
        'accessToken'  => 'access_token',
        'expiresIn'    => 'expires_in',
        'refreshToken' => 'refresh_token',
        'reExpiresIn'  => 're_expires_in',
    ];

    public function validate()
    {
        Model::validateRequired('httpBody', $this->httpBody, true);
        Model::validateRequired('code', $this->code, true);
        Model::validateRequired('msg', $this->msg, true);
        Model::validateRequired('subCode', $this->subCode, true);
        Model::validateRequired('subMsg', $this->subMsg, true);
        Model::validateRequired('userId', $this->userId, true);
        Model::validateRequired('accessToken', $this->accessToken, true);
        Model::validateRequired('expiresIn', $this->expiresIn, true);
        Model::validateRequired('refreshToken', $this->refreshToken, true);
        Model::validateRequired('reExpiresIn', $this->reExpiresIn, true);
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

        if ($this->userId !== null) {
            $res['user_id'] = $this->userId;
        }

        if ($this->accessToken !== null) {
            $res['access_token'] = $this->accessToken;
        }

        if ($this->expiresIn !== null) {
            $res['expires_in'] = $this->expiresIn;
        }

        if ($this->refreshToken !== null) {
            $res['refresh_token'] = $this->refreshToken;
        }

        if ($this->reExpiresIn !== null) {
            $res['re_expires_in'] = $this->reExpiresIn;
        }

        return $res;
    }

    /**
     * @param array $map
     *
     * @return AlipaySystemOauthTokenResponse
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

        if (isset($map['user_id'])) {
            $model->userId = $map['user_id'];
        }

        if (isset($map['access_token'])) {
            $model->accessToken = $map['access_token'];
        }

        if (isset($map['expires_in'])) {
            $model->expiresIn = $map['expires_in'];
        }

        if (isset($map['refresh_token'])) {
            $model->refreshToken = $map['refresh_token'];
        }

        if (isset($map['re_expires_in'])) {
            $model->reExpiresIn = $map['re_expires_in'];
        }

        return $model;
    }
}
