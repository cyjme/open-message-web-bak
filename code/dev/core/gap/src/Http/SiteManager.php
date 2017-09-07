<?php
namespace Gap\Http;

use Gap\Config\ConfigManager;

class SiteManager
{
    protected $siteMap;
    protected $hostMap = [];

    public function __construct($siteMap)
    {
        $this->siteMap = $siteMap;
    }

    public function getSite($host)
    {
        $hostMap = $this->getHostMap();

        if (!isset($hostMap[$host])) {
            // todo
            throw new \Exception("cannot find host $host");
        }

        return $hostMap[$host];
    }

    public function getHost($site)
    {
        return $this->siteMap[$site]['host'];
        //return ConfigManager::config()->get("site.$site.host");
    }

    public function getHostMap()
    {
        if ($this->hostMap) {
            return $this->hostMap;
        }

        foreach ($this->siteMap as $site => $opts) {
            $this->hostMap[$opts['host']] = $site;
        }

        return $this->hostMap;
    }
}
