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
    protected $openServer; // oauth2 server
    protected $openStorage;
    protected $openHandler;

    public function handle(RequestInterface $request)
    {
        $storage = new RedisStorage(
            $this->getCmg()->connect('oauth2')
        );

        $openServer = new OAuth2Server($storage);
        $openServer->addGrantType(new ClientCredentials($storage));
        $openServer->addGrantType(new AuthorizationCode($storage));
        $this->openServer = $openServer;

        $request->setSiteManager(new SiteManager($this->config->get('site')));
        $request->setLocaleManager(new LocaleManager($this->config->get('i18n.locale')));

        $this->getTranslator()->setDefaultLocaleKey($request->getLocaleKey());

        $this->openHandler = new OpenHandler($this);
        $this->openStorage = $storage;

        return $this->openHandler->handle($request);
    }

    public function getOpenServer()
    {
        return $this->openServer;
    }

    public function getOpenStorage()
    {
        return $this->openStorage;
    }
}
