<?php
namespace Openmessage\Startup\Trans\Repo;

class ListTransKeyRepo extends RepoBase
{
    public function listSet($opts)
    {

        $ssb = $this->cnn->select('key')
            ->from('trans')
            ->groupBy('key')
            ->orderBy('changed', 'desc');

        if ($query = prop($opts, 'query', '')) {
            $ssb
                ->orWhere('key', 'LIKE', "%$query%")
                ->orWhere('value', 'LIKE', "%$query%");
        }

        return $this->dataSet($ssb, 'Openmessage\Startup\Trans\Dto\TransKeyDto');
    }
}
