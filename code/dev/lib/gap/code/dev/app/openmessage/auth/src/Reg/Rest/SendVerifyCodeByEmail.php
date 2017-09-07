<?php
namespace Openmessage\Auth\Reg\Rest;

use Openmessage\Auth\Reg\Service\VerifyEmailService;
use Gap\Third\SendCloud\Mail\SendTemplate;

class SendVerifyCodeByEmail extends ControllerBase
{

    protected $mailer;

    public function post()
    {
        $email = $this->request->get('email');
        $effectiveTime = intval($this->getConfig()->get('mail.sendcloud.effective_time')) * 60;
        $emailCode = obj(new VerifyEmailService($this->app))->generateCode($email, $effectiveTime);
        $result = $this->sendMailCode($email, $emailCode);

        if ($result['result'] == true) {
            return $this->jsonResponse(['status' => 'ok']);
        }

        return $this->jsonResponse(['verification code' => 'send fail']);
    }

    protected function sendMailCode($email, $emailCode)
    {
        return $this->getMailer()->send([
            'templateInvokeName' => 'sendEmailCode',
            'fromName' => $this->app->getTranslator()->get('emailFrom'),
            'from' => 'no-reply@send.ideapar.com',
            'to' => $email,
            'subject' => $this->app->getTranslator()->get('emailSubject'),
            'vars' => json_encode([
                'to' => [$email],
                'sub' => [
                    '%name%' => [$email],
                    '%code%' => [$emailCode],
                ],
            ]),
        ]);
    }

    protected function getMailer()
    {
        if (!$this->mailer) {
            $this->mailer = new SendTemplate(
                $this->app->getConfig()->get('mail.sendcloud')
            );
        }
        return $this->mailer;
    }
}
