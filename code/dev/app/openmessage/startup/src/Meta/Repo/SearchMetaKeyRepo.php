<?php
namespace Openmessage\Startup\Meta\Repo;

class SearchMetaKeyRepo extends RepoBase
{
    public function searchSet($opts)
    {

        $ssb = $this->cnn->select('key')
            ->from('meta')
            ->groupBy('key')
            ->orderBy('changed', 'desc');

        if ($query = prop($opts, 'query', '')) {
            $ssb
                ->orWhere('key', 'LIKE', "%$query%")
                ->orWhere('value', 'LIKE', "%$query%");
        }

        return $this->dataSet($ssb, 'Openmessage\Startup\Meta\Dto\MetaKeyDto');
    }
}
