<?php
namespace Gap\Database\SqlBuilder\Mysql;

use Gap\Database\Help\SqlBinder;

class SqlBuilder
{

    use Support\WhereTrait;
    use Support\JoinTrait;
    use Support\OrderTrait;
    use Support\GroupTrait;
    use Support\FieldTrait;
    use Support\TableTrait;

    protected $adapter;
    protected $binder;

    protected $sql;
    protected $limit = 10;
    protected $offset = 0;

    public function __construct($adapter)
    {
        $this->adapter = $adapter;
        $this->binder = new \Gap\Database\Help\SqlBinder();
    }

    public function limit($limit)
    {
        $this->limit = (int) $limit;
        return $this;
    }

    public function offset($offset)
    {
        $this->offset = (int) $offset;
        return $this;
    }

    public function getExecutedSql()
    {
        return $this->sql;
    }

    public function getBinder()
    {
        return $this->binder;
    }

    protected function buildLimitSql()
    {
        if (!$this->limit) {
            return '';
        }
        return " LIMIT {$this->limit}";
    }

    protected function buildOffsetSql()
    {
        if (!$this->offset) {
            return '';
        }
        return " OFFSET {$this->offset}";
    }

    protected function buildStmt($sql)
    {
        $stmt = $this->adapter->prepare($sql);
        $stmt->bindValues($this->binder->getValues());
        $stmt->bindParams($this->binder->getParams());
        return $stmt;
    }
}
