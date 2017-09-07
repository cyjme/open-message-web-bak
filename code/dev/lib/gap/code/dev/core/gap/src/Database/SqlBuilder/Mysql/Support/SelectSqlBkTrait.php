<?php
namespace Gap\Database\SqlBuilder\Mysql\Support;

trait SelectSqlBkTrait
{
    public function fetchDtoAll($dtoClass)
    {
        $stmt = $this->buildSelectStmt();
        //$stmt->setFetchDto($dtoClass);
        $stmt->setFetchAssoc();
        $stmt->execute();

        while ($row = $stmt->fetch()) {
            yield new $dtoClass($row);
        }
        //return $stmt->fetchAll();
    }

    public function fetchObjAll()
    {
        return $this->listObj();
    }

    public function fetchObjOne()
    {
        return $this->fetchObj();
    }
}
