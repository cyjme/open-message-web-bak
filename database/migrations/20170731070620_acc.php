<?php

use Phinx\Migration\AbstractMigration;

class Acc extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('acc', ['id' => false, 'primary_key' => array('accId')]);
        $table->addColumn('accId', 'varbinary', ['limit' => 21])
            ->addColumn('userId', 'string', ['limit' => 21])
            ->addColumn('token', 'string', ['limit' => 21])
            ->addColumn('appId', 'string', ['limit' => 21])
            ->addColumn('props', 'string', ['limit' => 20])
            ->addColumn('status', 'string', ['limit' => 20])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();

        $table = $this->table('group', ['id' => false, 'primary_key' => array('groupId')]);
        $table->addColumn('groupId', 'varbinary', ['limit' => 21])
            ->addColumn('groupCode', 'string', ['limit' => 21])
            ->addColumn('appId', 'string', ['limit' => 21])
            ->addColumn('status', 'string', ['limit' => 20])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();

        $table = $this->table('acc_group', ['id' => false]);
        $table->addColumn('groupId', 'varbinary', ['limit' => 21])
            ->addColumn('accId', 'varbinary', ['limit' => 21])
            ->addColumn('appId', 'string', ['limit' => 21])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('acc');
        $this->dropTable('group');
    }
}
