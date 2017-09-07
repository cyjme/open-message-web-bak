<?php
namespace Openmessage\Startup\I18n\Repo;

use Openmessage\Startup\I18n\Dto\LocaleKeyDto;

class FetchLocaleKeyRepo extends RepoBase
{
    public function fetchLocaleKeySet($table, $idCol, $colId)
    {
        $ssb = $this->cnn->select('localeKey', 'isPrimary')
            ->from($table)
            ->where($idCol, '=', $colId);
        
        return $this->dataSet($ssb, LocaleKeyDto::class);
    }
}
