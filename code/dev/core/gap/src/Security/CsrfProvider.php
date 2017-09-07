<?php
namespace Gap\Security;

use Symfony\Component\HttpFoundation\Request;

// How to properly add CSRF token using PHP
// http://stackoverflow.com/questions/6287903/how-to-properly-add-csrf-token-using-php
// CSRF Token necessary when using Stateless(= Sessionless) Authentication?
// http://stackoverflow.com/questions/21357182/csrf-token-necessary-when-using-stateless-sessionless-authentication

// Stop using JWT for sessions
// http://cryto.net/~joepie91/blog/2016/06/13/stop-using-jwt-for-sessions/

// hash_equals
// https://secure.php.net/hash_equals

class CsrfProvider
{
    public function token(Request $request)
    {
        if ($token = $request->getSession()->get('token')) {
            return $token;
        }

        $token = bin2hex(random_bytes(8));
        $request->getSession()->set('token', $token);

        return $token;
    }

    public function verify(Request $request)
    {
        return hash_equals(
            $request->request->get('token'),
            $request->getSession()->get('token')
        );
    }
}
