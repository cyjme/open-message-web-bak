<?php
namespace Gap\Http;

use Gap\Http\Request;

class RequestFilterManager
{
    public function filter(Request $request)
    {
        $filters = [
            new RequestFilter\CsrfFilter(),
            new RequestFilter\I18nFilter()
        ];

        foreach ($filters as $filter) {
            if ($res = $filter->filter($request)) {
                return $res;
            }
        }
    }
}
