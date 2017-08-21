<?php
namespace Openmessage\Startup\Meta\Service;

use Openmessage\Startup\Meta\Repo\SearchMetaKeyRepo;

class SearchMetaKeyService extends ServiceBase
{
    public function searchSet($opts)
    {
        return obj(new SearchMetaKeyRepo($this->getDmg()))
            ->searchSet($opts);
    }
}
