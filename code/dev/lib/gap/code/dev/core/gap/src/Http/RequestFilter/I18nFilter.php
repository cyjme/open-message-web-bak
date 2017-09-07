<?php
namespace Gap\Http\Requestfilter;

use Gap\Http\Request;
//use Gap\I18n\Locale\LocaleManager;
//use Gap\Http\SiteManager;
use Symfony\Component\HttpFoundation\RedirectResponse;

class I18nFilter
{
    public function filter(Request $request)
    {
        $localeMode = $request->getLocaleMode();

        $fun = "filter" . ucfirst($localeMode);

        if (method_exists($this, $fun)) {
            return $this->$fun($request);
        }

        $request->initLocaleKey();
    }

    public function filterPath(Request $request)
    {
        $pathInfo = $request->getPathInfo();
        if ($pathInfo === '/') {
            $localeKey = $request->guessLocaleKey($request);
            return $this->localeRedirectResponse($request, $localeKey);
        }

        $path = substr($pathInfo, 1);
        $pos = strpos($path, '/');
        if ($pos === false) {
            if (!$request->isAvailableLocaleKey($path)) {
                // todo
                throw new \Exception('error request');
            }

            return $this->localeRedirectResponse($request, $path);
        }

        $localeKey = substr($path, 0, $pos);
        if (!$request->isAvailableLocaleKey($localeKey)) {
            // todo
            throw new \Exception('error locale request');
        }

        $path = substr($path, $pos);
        $request->setPath($path);
        $request->setLocaleKey($localeKey);
    }

    protected function localeRedirectResponse(Request $request, $locale)
    {
        $url = $request->isSecure() ? 'https://' : 'http://';
        $url .= $request->getHttpHost() . '/' . $locale . '/';
        return new RedirectResponse($url);
    }
}
