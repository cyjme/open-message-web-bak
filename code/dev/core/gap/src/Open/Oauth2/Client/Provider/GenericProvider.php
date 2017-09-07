<?php
namespace Gap\Open\Oauth2\Client\Provider;

use Gap\Exception\ClientException;
use Gap\Open\Oauth2\Dto\TokenDto;
use Gap\Open\Dto\UserDto;

class GenericProvider
{
    private $clientId;
    private $clientSecret;
    private $authorizeUri;
    private $tokenUri;
    private $userUri;
    private $redirectUri;
    private $responseType;

    public function __construct(array $opts = [])
    {
        $this->assertRequiredOptions($opts);

        foreach ($opts as $key => $value) {
            $this->$key = $value;
        }

        $this->responseType = $opts['responseType'] ?? 'code';
    }

    public function fetchTokenByCode($code)
    {
        $postData = [
            'client_id' => $this->clientId,
            'grant_type' => 'authorization_code',
            'client_secret' => $this->clientSecret,
            'redirect_uri' => $this->redirectUri,
            'code' => $code
        ];

        $curlRes = curl_init();
        curl_setopt($curlRes, CURLOPT_URL, $this->tokenUri);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlRes, CURLOPT_POST, 1);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($curlRes);

        if (curl_errno($curlRes)) {
            throw new \Exception('Curl error: ' . curl_error($curlRes));
        }

        $httpCode = curl_getinfo($curlRes, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            throw new \Exception('Unexprected Http code: ' . $httpCode . ' - ' . $this->tokenUri);
        }

        curl_close($curlRes);

        $res = json_decode($output, true);

        return new TokenDto([
            'accessToken' => $res['access_token'],
            'expiresIn' => $res['expires_in'],
            'tokenType' => $res['token_type'],
            'scope' => $res['scope'],
            'refreshToken' => $res['refresh_token'],
            'userId' => $res['user_id']
        ]);
    }

    public function post($apiUrl, $token, $postData = [])
    {
        $curlRes = curl_init();
        curl_setopt($curlRes, CURLOPT_URL, $apiUrl);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlRes, CURLOPT_POST, 1);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postData);

        $headers = [
            'Content-Type: application/x-www-form-urlencoded',
            'Authorization: Bearer ' . $token
        ];

        curl_setopt($curlRes, CURLOPT_HTTPHEADER, $headers);

        $output = curl_exec($curlRes);

        if (curl_errno($curlRes)) {
            throw new \Exception('Curl error: ' . curl_error($curlRes));
        }

        $httpCode = curl_getinfo($curlRes, CURLINFO_HTTP_CODE);
        if ($httpCode != 200) {
            throw new \Exception('Unexprected Http code: ' . $httpCode . ' - ' . $apiUrl . 'output: ' . $output);
        }

        curl_close($curlRes);

        $res = json_decode($output, true);

        return $res;
    }

    public function getAccessToken($code)
    {
        $clientId = $this->clientId;
        $grantType = 'authorization_code';
        $clientSecret = $this->clientSecret;
        $redirectUri = $this->redirectUri;

        $postData = [
            'client_id' => $clientId,
            'grant_type' => $grantType,
            'client_secret' => $clientSecret,
            'redirect_uri' => $redirectUri,
            'code' => $code
        ];

        $curlRes = curl_init();
        curl_setopt($curlRes, CURLOPT_URL, $this->tokenUri);
        curl_setopt($curlRes, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($curlRes, CURLOPT_POST, 1);
        curl_setopt($curlRes, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($curlRes);
        curl_close($curlRes);

        $res = json_decode($output, true);

        if (array_key_exists('error', $res)) {
            throw new ClientException($res['error_description']);
        }

        if ($accessToken = $res['access_token']) {
            return $accessToken;
        }
    }

    public function getResponseType()
    {
        return $this->responseType;
    }

    public function getClientId()
    {
        return $this->clientId;
    }

    public function getRedirectUri()
    {
        return $this->redirectUri;
    }

    public function getUser($token)
    {
        $uri = $this->userUri. "?access_token=$token";
        return new UserDto(json_decode(file_get_contents($uri), true)['user']);
    }

    public function getAuthorizationUri($state = '')
    {
        $responseType = $this->responseType;
        $clientId = $this->clientId;
        $redirectUri = $this->redirectUri;

        $query = http_build_query([
            'response_type' => $responseType,
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'state'         => $state
        ]);

        return $this->authorizeUri . '?' . $query;
    }


    private function assertRequiredOptions(array $opts)
    {
        $missing = array_diff_key(array_flip($this->getRequiredOptions()), $opts);

        if (!empty($missing)) {
            throw new \InvalidArgumentException(
                'Required options not defined: ' . implode(', ', array_keys($missing))
            );
        }
    }

    protected function getRequiredOptions()
    {
        return [
            'clientId',
            'clientSecret',
            'redirectUri',
            'authorizeUri',
            'tokenUri',
            'userUri',
        ];
    }
}
