<?php
namespace Gap\Database\SqlBuilder\Mysql;

class DeleteSqlBuilder extends SqlBuilder
{

    private $deleteAliases = [];

    public function deleteAliases($aliases)
    {
        foreach ($aliases as $alias) {
            $this->deleteAlias($alias);
        }
    }

    public function deleteAlias($alias)
    {
        if ($alias = trim($alias)) {
            $this->deleteAliases[] = "`$alias`";
        }
    }

    public function buildAliasesSql()
    {
        if ($this->deleteAliases) {
            return implode(', ', $this->deleteAliases);
        }

        return implode(', ', $this->table_aliases);
    }

    public function execute()
    {
        $stmt = $this->buildStmt($this->buildDeleteSql());
        return $stmt->execute();
    }

    public function buildDeleteSql()
    {
        $this->sql = "DELETE " . $this->buildAliasesSql()
            . ' FROM' . $this->buildTableSql()
            . $this->buildJoinSql()
            . $this->buildWhereSql()
            . $this->buildOrderBySql();
            //. $this->buildLimitSql()
            //. $this->buildOffsetSql();

        return $this->sql;
    }
}
