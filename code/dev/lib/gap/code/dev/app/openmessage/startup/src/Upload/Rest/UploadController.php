<?php
namespace Openmessage\Startup\Upload\Rest;

use Qiniu\Auth;
use Qiniu\Storage\UploadManager;

class UploadController extends ControllerBase
{
    public function post()
    {
        $accessKey = $this->config->get('qiniu.accessKey');
        $secretKey = $this->config->get('qiniu.secretKey');

        $auth = new Auth($accessKey, $secretKey);
        $bucket = $this->config->get('qiniu.bucket');
        $token = $auth->uploadToken($bucket);

        $response = [
            'errno'=>0,
            'data'=>[]
        ];

        foreach ($_FILES as $file) {
            $filePath = $file['tmp_name'];
            $key = uniqid('editor', true);
            $uploadManager = new UploadManager();
            list($ret, $err) = $uploadManager->putFile($token, $key, $filePath);
            if ($err !== null) {
                $response['errno'] = $err;
            } else {
                $response['data'][] = $this->spliceUrl($ret['key']);
            }
        }

        return $this->jsonResponse($response);
    }

    private function spliceUrl($key)
    {

        $domain = $this->config->get('qiniu.domain');

        return $domain.$key;
    }
}
