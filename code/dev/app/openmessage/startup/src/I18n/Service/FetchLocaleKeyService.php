<?php
namespace Openmessage\Startup\I18n\Service;

use Openmessage\Startup\I18n\Repo\FetchLocaleKeyRepo;

class FetchLocaleKeyService extends ServiceBase
{
    public function fetchSet($table, $idCol, $colId)
    {
        return obj(new FetchLocaleKeyRepo($this->getDmg()))
            ->fetchLocaleKeySet($table, $idCol, $colId);
    }

    public function fetchAsm($table, $idCol, $colId)
    {
        $localeKeysSet = $this->fetchSet($table, $idCol, $colId);

        $localeKeyAsm = [];
        foreach ($localeKeysSet->getItems() as $item) {
            $localeKeyAsm[$item->getLocaleKey()] = $item;
        }

        return $localeKeyAsm;
    }
}
