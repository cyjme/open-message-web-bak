<?php
namespace phpunit\Gap\Third\Mail;

use Gap\Third\SendCloud\Mail\SendTemplate;

class SendTemplteTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $sendFrom = 'no-reply@send.ideapar.com';
        $sendFromName = 'no-replay';
        $sendTo = '286186887@qq.com';
        $sendToName  = 'zhanjh';
        $subject = 'phpunit use sendcloud sendtemlate at ' . date(DATE_ATOM);

        $sendTemplate = new SendTemplate(
            console_app()->getConfig()->get('mail.sendcloud.api')
        );

        $result = $sendTemplate->send([
            'templateInvokeName' => 'active',
            'from' => $sendFrom,
            'fromName' => $sendFromName,
            'subject' => $subject,
            'vars' => json_encode([
                'to' => [$sendTo],
                'sub' => [
                    '%name%' => [$sendToName],
                    '%link%' => [
                        'http://www.tecposter.com'
                    ]
                ]
            ])
        ]);

        $this->assertTrue($result['result']);
        $this->assertEquals(200, $result['statusCode']);
    }
}
