<?php
namespace Gap\Http\RequestFilter;

use Symfony\Component\HttpFoundation\Request;
use Gap\Security\CsrfProvider;

class CsrfFilter
{
    public function filter(Request $request)
    {
        if ($request->isMethod('POST')) {
            if (!obj(new CsrfProvider)->verify($request)) {
                // todo
                throw new \Exception("Error Request");
            }
        }
    }
}
