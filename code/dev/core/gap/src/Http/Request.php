<?php
namespace Gap\Http;

use Symfony\Component\HttpFoundation\Request as SymfonyRequest;
use Gap\Http\SiteManager;
use Gap\I18n\Locale\LocaleManager;
use Gap\Routing\Route;

class Request extends SymfonyRequest
{
    protected $siteManager;
    protected $localeManager;
    protected $route;

    public function setSiteManager(SiteManager $siteManager)
    {
        $this->siteManager = $siteManager;
    }

    public function getSiteManager()
    {
        return $this->siteManager;
    }

    public function setLocaleManager(LocaleManager $localeManager)
    {
        $this->localeManager = $localeManager;
    }

    public function initLocaleKey()
    {
        $this->setLocaleKey($this->localeManager->getDefaultLocaleKey());
    }

    public function setLocaleKey($localeKey)
    {
        $this->attributes->set('localeKey', $localeKey);
    }

    public function isAvailableLocaleKey($localeKey)
    {
        return $this->localeManager->isAvailableLocaleKey($localeKey);
    }

    public function guessLocaleKey()
    {
        foreach ($this->getLanguages() as $lang) {
            $localeKey = str_replace('_', '-', strtolower($lang));
            if ($this->localeManager->isAvailableLocaleKey($localeKey)) {
                return $localeKey;
            }
        }
        return $this->localeManager->getDefaultLocaleKey();
    }

    public function getLocaleKey()
    {
        if ($localeKey = $this->attributes->get('localeKey')) {
            return $localeKey;
        }

        return $this->guessLocaleKey();
    }

    public function getSite()
    {
        $host = $this->getHttpHost();
         return $this->siteManager->getSite($host);
    }

    public function getLocaleMode()
    {
        return $this->localeManager->getMode();
    }

    public function setPath($path)
    {
        $this->attributes->set('path', $path);
    }

    public function getPath()
    {
        if ($path = $this->attributes->get('path')) {
            return $path;
        }

        return $this->getPathInfo();
    }

    public function getUserId()
    {
        return $this->getSession()->get('userId');
    }

    public function setUserId($userId)
    {
        $this->getSession()->set('userId', $userId);
        return $this;
    }

    public function getUserName()
    {
        return $this->getSession()->get('userName');
    }

    public function setUserName($userName)
    {
        $this->getSession()->set('userName', $userName);
        return $this;
    }

    public function setRoute(Route $route)
    {
        $this->route = $route;
        return $this;
    }

    public function getRoute()
    {
        return $this->route;
    }
}
