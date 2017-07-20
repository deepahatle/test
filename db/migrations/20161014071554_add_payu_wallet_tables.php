<?php

use Phinx\Migration\AbstractMigration;

class AddPayuWalletTables extends AbstractMigration
{
    /**
     * Change Method.
     *
     * Write your reversible migrations using this method.
     *
     * More information on writing migrations is available here:
     * http://docs.phinx.org/en/latest/migrations.html#the-abstractmigration-class
     *
     * The following commands can be used in this method and Phinx will
     * automatically reverse them when rolling back:
     *
     *    createTable
     *    renameTable
     *    addColumn
     *    renameColumn
     *    addIndex
     *    addForeignKey
     *
     * Remember to call "create()" or "update()" and NOT "save()" when working
     * with the Table class.
     */
    public function change()
    {
        //create table PayU Wallet Auth
        $table = $this->table("payu_wallet_auth", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))   
            ->addColumn('email', 'string', array('limit' => 200, 'null' => true))
            ->addColumn('mobileno', 'string', array('limit' => 20, 'null' => true))
            ->addColumn('auth_token', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('refresh_token', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('token_type', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('scope', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('status', 'string', array('limit' => 50, 'null' => true))
            ->addColumn('login_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('login_id', 'login', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->create();
    }
}
