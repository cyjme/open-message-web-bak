<?php

use Phinx\Migration\AbstractMigration;

class PushMessage extends AbstractMigration
{
    public function up()
    {
        $table = $this->table('push', ['id' => false, 'primary_key' => array('pushId')]);
        $table->addColumn('pushId', 'varbinary', ['limit' => 21])
            ->addColumn('createdUserId', 'varbinary', ['limit' => 21])
            ->addColumn('companyId', 'varbinary', ['limit' => 21])
            ->addColumn('appId', 'varbinary', ['limit' => 21])
            ->addColumn('title', 'string', ['limit' => 255])
            ->addColumn('content', 'text')
            ->addColumn('toAccId', 'varbinary', ['limit' => 21])
            ->addColumn('toGroupId', 'varbinary', ['limit' => 21])
            ->addColumn('created', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->addColumn('changed', 'timestamp', ['default' => 'CURRENT_TIMESTAMP'])
            ->save();
    }

    public function down()
    {
        $this->dropTable('push');
    }
}
