<?php

namespace Gap\Open;

class Request extends \Gap\Http\Request implements \OAuth2\RequestInterface
{
    public function query($name, $default = null)
    {
        return $this->query->get($name, $default);
    }

    public function request($name, $default = null)
    {
        return $this->request->get($name, $default);
    }

    public function server($name, $default = null)
    {
        return $this->server->get($name, $default);
    }

    public function headers($name, $default = null)
    {
        return $this->headers->get($name, $default);
    }

    public function getAllQueryParameters()
    {
        return $this->query->all();
    }

    public function getAccessToken()
    {
        if ($accessToken = $this->query->get('access_token')) {
            return $accessToken;
        }

        $authorization = $this->headers->get('authorization');
        if (0 === strpos($authorization, 'Bearer ')) {
            $accessToken = trim(substr($authorization, 6));
            return $accessToken;
        }

        return null;
    }
}
