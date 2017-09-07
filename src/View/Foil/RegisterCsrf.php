<?php
namespace Gap\View\Foil;

use Gap\Http\Request;
use Gap\Security\CsrfProvider;

class RegisterCsrf extends RegisterBase
{
    public function register(Request $request)
    {
        $this->engine->registerFunction(
            'csrf',
            function () use ($request) {
                $token = obj(new CsrfProvider())->token($request);
                return "<input type=\"hidden\" name=\"token\" value=\"$token\">";
            }
        );

        $this->engine->registerFunction(
            'token',
            function () use ($request) {
                return obj(new CsrfProvider())->token($request);
            }
        );
    }
}
