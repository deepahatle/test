<?php

use Phinx\Migration\AbstractMigration;

class LoginLabAddColumns extends AbstractMigration
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
        $table = $this->table("lab");
        $table->addColumn('doctor', 'string', array('length' => 100, 'null' => false))
            ->addColumn('signature', 'string', array('length' => 500, 'null' => false))
            ->addColumn('logo', 'string', array('length' => 500, 'null' => true))
            ->update();

        $table = $this->table("login");
        $table->addColumn('expiry', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('is_trial', 'string', array('length' => 10, 'null' => true))
            ->update();
    }
}
