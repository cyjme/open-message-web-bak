<?php
namespace Openmessage\Startup\Qiniu\Rest;

use Qiniu\Auth;

class FetchUpTokenController extends ControllerBase
{
    public function show()
    {
        $accessKey = $this->config->get('qiniu.accessKey');
        $secretKey = $this->config->get('qiniu.secretKey');
        $auth = new Auth($accessKey, $secretKey);
        
        $bucket = $this->config->get('qiniu.bucket');
        $token = $auth->uploadToken($bucket);

        return $this->jsonResponse(["uptoken" => $token]);
    }
}
