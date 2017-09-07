<?php

namespace Gap\Contract\Repo;

use Gap\Config\ConfigManager;
use Gap\Database\DatabaseManager;
use Gap\Database\DataSet;
use Gap\Contract\Database\SqlBuilder\SelectSqlBuilderInterface;

abstract class RepoBase
{
    protected $cnnName;
    protected $cnn;

    protected $fieldTypeMap;
    protected $dmg;

    public function __construct(DatabaseManager $dmg)
    {
        $this->dmg = $dmg;

        if (empty($this->cnnName)) {
            // todo
            //throw new Exception\RepoException("cnnName could not be empty");
            throw new \Exception("cnnName could not be empty");
        }

        $this->cnn = $this->dmg->connect($this->cnnName);

        $this->startup();
    }

    protected function startup()
    {
    }

    protected function getFieldType($fieldName)
    {
        $fieldType = $this->fieldTypeMap[$fieldName] ?? '';
        if (!$fieldType) {
            // todo
            throw new \Exception("unkown field name: $fieldName");
        }
        return $fieldType;
    }

    protected function dataSet(SelectSqlBuilderInterface $ssb, $dtoClass)
    {
        return new DataSet($ssb, $dtoClass);
    }
}
