<?php
namespace Gap\App\Open;

use Gap\App\App;
use OAuth2\RequestInterface;
use OAuth2\Storage\Redis as RedisStorage;
use OAuth2\Server as OAuth2Server;
use OAuth2\GrantType\ClientCredentials;
use OAuth2\GrantType\AuthorizationCode;
use Gap\Http\SiteManager;
use Gap\I18n\Locale\LocaleManager;
use Gap\Open\OpenHandler;

class OpenApp extends App
{
    protected $oauth2Server; // oauth2 server
    protected $oauth2Storage;
    protected $openHandler;

    public function handle(RequestInterface $request)
    {
        $storage = new RedisStorage(
            $this->getCmg()->connect('oauth2')
        );

        $oauth2Server = new OAuth2Server($storage);
        $oauth2Server->addGrantType(new ClientCredentials($storage));
        $oauth2Server->addGrantType(new AuthorizationCode($storage));
        $this->oauth2Server = $oauth2Server;

        $request->setSiteManager(new SiteManager($this->config->get('site')));
        $request->setLocaleManager(new LocaleManager($this->config->get('i18n.locale')));

        $this->getTranslator()->setDefaultLocaleKey($request->getLocaleKey());

        $this->openHandler = new OpenHandler($this);
        $this->oauth2Storage = $storage;

        return $this->openHandler->handle($request);
    }

    public function getOauth2Server()
    {
        return $this->oauth2Server;
    }

    public function getOauth2Storage()
    {
        return $this->oauth2Storage;
    }


    //
    // deprecated
    //
    public function getOpenServer()
    {
        return $this->oauth2Server;
    }

    public function getOpenStorage()
    {
        return $this->oauth2Storage;
    }
}
