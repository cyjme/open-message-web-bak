<?php
namespace Openmessage\Msg\Msg\Repo;

class UpdateReadAllTimeRepo extends RepoBase
{
    public function updateByToken($token)
    {
        $now = micro_date();

        $this->cnn->update('acc')
            ->where('token', '=', $token)
            ->set('changed', $now)
            ->execute();

        return $now;
    }
}
