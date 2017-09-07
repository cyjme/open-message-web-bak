<?php
namespace Gap\Database\Connection\Support;

use Gap\Database\SqlBuilder\Mysql\SelectSqlBuilder;
use Gap\Database\SqlBuilder\Mysql\UpdateSqlBuilder;
use Gap\Database\SqlBuilder\Mysql\DeleteSqlBuilder;
use Gap\Database\SqlBuilder\Mysql\InsertSqlBuilder;

trait MysqlSqlBuilderTrait
{
    public function select(...$fields)
    {
        $ssb = new SelectSqlBuilder($this);
        $ssb->fields($fields);
        return $ssb;
    }

    public function update(...$tables)
    {
        $usb = new UpdateSqlBuilder($this);
        $usb->tables($tables);
        return $usb;
    }

    public function insert(...$tables)
    {
        $isb = new InsertSqlBuilder($this);
        $isb->tables($tables);
        return $isb;
    }

    public function delete(...$aliases)
    {
        $dsb = new DeleteSqlBuilder($this);
        $dsb->deleteAliases($aliases);
        return $dsb;
    }
}
