<?php

use Phinx\Migration\AbstractMigration;
use Phinx\Db\Adapter\MysqlAdapter;

class Company extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('company', ['id' => false, 'primary_key' => array('companyId')]);
        $table->addColumn('companyId', 'varbinary', ['limit' => 21])
            ->addColumn('companyCode', 'string', ['limit' => 21])
            ->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('userId', 'string', ['limit' => 20])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();

        $table = $this->table('app', ['id' => false, 'primary_key' => array('appId')]);
        $table->addColumn('appId', 'varbinary', ['limit' => 21])
            ->addColumn('appCode', 'string', ['limit' => 21])
            ->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('desc', 'string', ['limit' => 20])
            ->addColumn('key', 'string', ['limit' => 20])
            ->addColumn('secret', 'string', ['limit' => 20])
            ->addColumn('status', 'string', ['limit' => 20])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();

        $table = $this->table('user', ['id' => false, 'primary_key' => array('userId')]);
        $table->addColumn('userId', 'varbinary', ['limit' => 21])
            ->addColumn('userCode', 'string', ['limit' => 21])
            ->addColumn('name', 'string', ['limit' => 20])
            ->addColumn('email', 'string', ['limit' => 20])
            ->addColumn('phone', 'string', ['limit' => 20])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('company');
        $this->dropTable('app');
        $this->dropTable('user');
    }
}
