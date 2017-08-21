<?php
namespace Openmessage\Auth\Reg\Rest;

use Gap\Third\SendCloud\Sms\SendTemplate;
use Openmessage\Auth\Reg\Service\VerifyPhoneService;

class SendVerifyCodeByPhone extends ControllerBase
{
    protected $sms;

    public function post()
    {
        $phone = $this->request->get('phone');
        $effectiveTime = intval($this->getConfig()->get('sms.sendcloud.effective_time')) * 60;
        $phoneCode = obj(new VerifyPhoneService($this->app))->generateCode($phone, $effectiveTime);
        $result = $this->sendPhoneCode($phone, $phoneCode);

        if ($result['result'] == true) {
            return $this->jsonResponse(['status' => 'ok']);
        }

        return $this->jsonResponse(['verification code' => 'send fail']);
    }

    public function sendPhoneCode($phone, $phoneCode)
    {
        $effectiveTime = $this->getConfig()->get('sms.sendcloud.effective_time');
        $templateId = $this->getConfig()->get('sms.sendcloud.templateId');
        return $this->getSms()->send([
            'templateId' => $templateId,
            'phoneNumber' => $phone,
            'vars' => [
                '%smsCode%' => $phoneCode,
                '%effectiveTime%' => $this->getTranslator()->get($effectiveTime)
            ]
        ]);
    }

    public function getSms()
    {
        if (!$this->sms) {
            $this->sms = new SendTemplate(
                $this->getConfig()->get('sms.sendcloud')
            );
        }

        return $this->sms;
    }
}
