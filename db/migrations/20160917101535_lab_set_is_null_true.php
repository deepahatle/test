<?php

use Phinx\Migration\AbstractMigration;

class LabSetIsNullTrue extends AbstractMigration
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
        $table->changeColumn('address', 'string', array('limit' => 200, 'null' => true));
        $table->changeColumn('city', 'string', array('limit' => 200, 'null' => true));
        $table->changeColumn('pincode', 'integer', array('limit' => 20, 'null' => true));
        $table->changeColumn('doctor', 'string', array('length' => 100, 'null' => true));
        $table->changeColumn('signature', 'string', array('length' => 500, 'null' => true));
        $table->update();
    }
}
