<?php
namespace Openmessage\Auth\Login\Ui;

use Gap\Exception\ClientException;
use Gap\Security\CsrfProvider;
use Openmessage\Auth\Reg\Service\SaveUserService;
use Openmessage\Auth\User\Dto\UserDto;
use Openmessage\Auth\User\Service\FetchUserByUserIdService;

class OAuthController extends ControllerBase
{
    protected $responseType;
    protected $clientId;
    protected $redirectUri;
    protected $authorizationRequestUri;
    protected $clientSecret;
    protected $requestTokenUri;
    protected $requestUserInfoUri;
    protected $regUri;

    public function bootstrap()
    {
        $config = $this->app->getConfig();
        $this->responseType = 'code';
        $this->clientId = $config->get('oauth.clientId');
        $this->redirectUri = $config->get('oauth.redirectUri');
        $this->authorizationRequestUri = $config->get('oauth.authorizationRequestUri');
        $this->clientSecret = $config->get('oauth.clientSecret');
        $this->requestTokenUri = $config->get('oauth.requestTokenUri');
        $this->requestUserInfoUri = $config->get('oauth.requestUserInfoUri');
        $this->regUri = $config->get('oauth.regUri');
    }

    public function getAuthorizationCode()
    {
        $responseType = $this->responseType;
        $clientId = $this->clientId;
        $redirectUri = $this->redirectUri;
        $state = obj(new CsrfProvider())->token($this->request);

        $query = http_build_query([
            'response_type' => $responseType,
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'state'         => $state
        ]);

        $url = $this->authorizationRequestUri . '?' . $query;
        return $this->gotoUrl($url);
    }

    public function oauthReg()
    {
        $responseType = $this->responseType;
        $clientId = $this->clientId;
        $redirectUri = $this->redirectUri;
        $state = obj(new CsrfProvider())->token($this->request);

        $query = http_build_query([
            'response_type' => $responseType,
            'client_id'     => $clientId,
            'redirect_uri'  => $redirectUri,
            'state'         => $state
        ]);

        $url = $this->regUri . '?' . $query;
        return $this->gotoUrl($url);
    }

    public function callBack()
    {
        $post = $this->request->query;

        if (!$code = $post->get('code')) {
            throw new ClientException('code cannot be null');
        }

        $token = $this->getAccessToken($code);
        if (!$token) {
            throw new ClientException('token cannot be null');
        }

        $resource = json_decode($this->getResource($token), true);

        if ($resource == null) {
            throw new ClientException('resource cannot be null');
        }

        $user = $resource['user'];
        $userId = $user['userId'];
        $email = $resource['email'];
        $phone = $resource['phone'];

        if ((new FetchUserByUserIdService($this->app))->fetchOneByUserId($userId) == null) {
            $user = new UserDto($user);
            obj(new SaveUserService($this->app))->save($user, $email, $phone);
        }
        $this->request->setUserId($userId);

        return $this->gotoRouteGet('massHome');
    }

    protected function getAccessToken($code)
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

        $fetchToken = $this->requestTokenUri;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $fetchToken);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);
        $output = curl_exec($ch);
        curl_close($ch);

        $res = json_decode($output, true);

        if (array_key_exists('error', $res)) {
            throw new ClientException($res['error_description']);
        }

        if ($accessToken = $res['access_token']) {
            return $accessToken;
        }
    }

    protected function getResource($token)
    {
        $uri = $this->requestUserInfoUri. "?access_token=$token";
        return file_get_contents($uri);
    }
}
