<?php
namespace Gap\Third\SendCloud\Sms;

class SendTemplate
{
    protected $apiUser;
    protected $apiKey;
    protected $msgType = 0;

    protected $apiUrl = 'http://sendcloud.sohu.com/smsapi/send';

    public function __construct($opts)
    {
        $this->apiUser = $opts['apiUser'];
        $this->apiKey = $opts['apiKey'];
    }

    public function send($args)
    {
        $param = [
            'smsUser' => $this->apiUser,
            'msgType' => $this->msgType,
            'templateId' => $args['templateId'],
            'phone' => $args['phoneNumber'],
        ];

        $paramVars = [];
        foreach ($args['vars'] as $key => $val) {
            $paramVars[] = "\"$key\":\"$val\"";
        }

        $param['vars'] = '{' . implode(',', $paramVars) . '}';

        $sParamStr = "";
        ksort($param);
        foreach ($param as $sKey => $sValue) {
            $sParamStr .= $sKey . '=' . $sValue . '&';
        }

        $sParamStr = trim($sParamStr, '&');
        $smskey = $this->apiKey;
        $sSignature = md5($smskey . "&" . $sParamStr . "&" . $smskey);

        $param['signature'] = $sSignature;

        $data = http_build_query($param);
        $options = array(
            'http' => array(
                'method' => 'POST',
                'header' => 'Content-Type:application/x-www-form-urlencoded',
                'content' => $data
            ));
        $context = stream_context_create($options);
        $result = file_get_contents($this->apiUrl, FILE_TEXT, $context);

        return json_decode($result, true);
    }
}
