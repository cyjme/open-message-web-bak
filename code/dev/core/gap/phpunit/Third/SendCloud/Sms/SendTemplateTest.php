<?php
namespace phpunit\Gap\Third\Sms;

use Gap\Third\SendCloud\Sms\SendTemplate;

class SendTemplateTest extends \PHPUnit_Framework_TestCase
{
    public function testSend()
    {
        $phoneNumber = '13564341910';
        $smsCode = '123456';

        $sendTemplate = new SendTemplate(
            console_app()->getConfig()->get('sms.sendcloud.api')
        );

        $result = $sendTemplate->send([
            'phoneNumber' => $phoneNumber,
            'templateId' => 3393,
            'vars' => [
                'smsCode' => $smsCode,
                'effectiveTime' => '30-minute'
            ]
        ]);

        $this->assertTrue($result['result']);
        $this->assertEquals(200, $result['statusCode']);
    }
}
