<?php
namespace Gap\Database\SqlBuilder\Mysql;

class UpdateSqlBuilder extends SqlBuilder
{

    protected $sets = [];

    public function set($field, $value, $type = 'str')
    {
        $param = $this->binder->toParam($field);
        $sqlField = $this->binder->toField($field);
        $this->sets[] = "$sqlField = $param";
        $this->binder->bindValue($param, $value, $type);
        return $this;
    }

    public function setRaw($field, $raw)
    {
        $sqlField = $this->binder->toField($field);
        $this->sets[] = "$sqlField = $raw";
        return $this;
    }

    public function incr($field, $rate = 1)
    {
        $sqlField = $this->binder->toField($field);
        $operate = $rate > 0 ? '+' : '-';
        $rate = abs($rate);
        $this->sets[] = "$sqlField = $sqlField $operate $rate";
        return $this;
    }

    public function sets(array $values)
    {
        foreach ($values as $key => $item) {
            $val = $item;
            $type = 'str';

            if (is_array($item) && isset($item[1])) {
                $val = $item[0];
                $type = $item[1];
            }

            $this->set($key, $val, $type);
        }
        return $this;
    }

    public function execute()
    {
        $stmt = $this->buildStmt($this->buildUpdateSql());
        return $stmt->execute();
    }

    public function buildUpdateSql()
    {
        $this->sql = "UPDATE " . implode(', ', $this->tables)
            . $this->buildJoinSql()
            . ' SET ' . implode(', ', $this->sets)
            . $this->buildWhereSql();

        return $this->sql;
    }
}
