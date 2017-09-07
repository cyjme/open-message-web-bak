<?php
namespace Gap\Third\SendCloud\Mail;

class SendTemplate
{
    protected $apiUser;
    protected $apiKey;

    protected $apiUrl = 'http://api.sendcloud.net/apiv2/mail/sendtemplate';

    public function __construct($opts)
    {
        $this->apiUser = $opts['apiUser'];
        $this->apiKey = $opts['apiKey'];
    }

    public function send($args)
    {
        $params = [
            'apiUser' => $this->apiUser,
            'apiKey' => $this->apiKey,
            'from' => $args['from'],
            'fromName' => $args['fromName'],
            'xsmtpapi' => $args['vars'],
            'templateInvokeName' => $args['templateInvokeName'],
            'subject' => $args['subject'],
            'respEmailId' => 'true',
        ];

        $data = http_build_query($params);
        $opts = [
            'http' => [
                'method' => 'POST',
                'header' => 'Content-Type: application/x-www-form-urlencoded',
                'content' => $data
            ]
        ];
        $context = stream_context_create($opts);
        $result = file_get_contents($this->apiUrl, FILE_TEXT, $context);

        return json_decode($result, true);
    }
}
