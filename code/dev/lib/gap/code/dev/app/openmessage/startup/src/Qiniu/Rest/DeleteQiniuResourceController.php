<?php
namespace Openmessage\Startup\Qiniu\Rest;

use Qiniu\Auth;
use Qiniu\Storage\BucketManager;

class DeleteQiniuResourceController extends ControllerBase
{
    public function post()
    {
        $accessKey = $this->config->get('qiniu.accessKey');
        $secretKey = $this->config->get('qiniu.secretKey');
        $auth = new Auth($accessKey, $secretKey);
        $bucketMgr = new BucketManager($auth);
        
        $bucket = $this->config->get('qiniu.bucket');
        $key = $this->request->request->get('key');
        $result = $bucketMgr->delete($bucket, $key);

        return $this->jsonResponse(["result" => $result]);
    }
}
