<?php

use Phinx\Migration\AbstractMigration;

class CreateTable extends AbstractMigration
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
        //create table login
        $table = $this->table("login", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('mobileno', 'string', array('limit' => 20, 'null' => false))
            ->addColumn('username', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('pass', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('user_type', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('salt', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addColumn('is_active', 'string', array('limit' => 100, 'null' => false))
            ->addColumn('roles', 'text', array('null' => false))
            ->create();

        //create table lab
        $table = $this->table("lab", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('email', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('mobile', 'string', array('limit' => 20, 'null' => false))
            ->addColumn('address', 'text')
            ->addColumn('city', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('pincode', 'integer', array('limit' => 20, 'null' => false))
            ->addColumn('registration_no', 'string', array('limit' => 100, 'null' => false))
            ->addColumn('login_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('login_id', 'login', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->create();

        // create table doctor
        $table = $this->table("doctor", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('email', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('mobile', 'string', array('limit' => 20, 'null' => false))
            ->addColumn('address', 'text')
            ->addColumn('city', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('percentage', 'string', array('limit' => 10, 'null' => false))
            ->addColumn('lab_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('lab_id', 'lab', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->create();

        // create table user
        $table = $this->table("user", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('email', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('mobile', 'string', array('limit' => 20, 'null' => false))
            ->addColumn('address', 'text')
            ->addColumn('city', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('gender', 'string', array('limit' => 1, 'null' => false))
            ->addColumn('age', 'integer', array('limit' => 3, 'null' => false))
            ->addColumn('patient_id', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('login_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('login_id', 'login', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->create();

        // create table department master
        $table = $this->table("department_master", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('code', 'string', array('limit' => 50, 'null' => false))
            ->create();

        // create table tax master
        $table = $this->table("tax_master", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('percentage', 'string', array('limit' => 10, 'null' => false))
            ->create();

        // create table test master
        $table = $this->table("test_master", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('name', 'string', array('limit' => 200, 'null' => false))
            ->addColumn('department_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('department_id', 'department_master', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('default_cost', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('lower_value', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('higher_value', 'string', array('limit' => 50, 'null' => false))
            ->create();

        // create table lab test
        $table = $this->table("lab_test", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('test_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('test_id', 'test_master', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('lab_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('lab_id', 'lab', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('cost', 'string', array('null' => false, 'limit' => 50, 'default' => 0))
            ->create();

        // create table user visit
        $table = $this->table("user_visit", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('lab_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('lab_id', 'lab', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('user_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('user_id', 'user', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('doctor_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('doctor_id', 'doctor', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('total_amount', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('discount', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('net_amount', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('paid_amount', 'string', array('limit' => 50, 'null' => false))
            ->addColumn('tax_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('tax_id', 'tax_master', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('enable_view_for_user', 'string', array('limit' => 10, 'null' => false))
            ->addColumn('status', 'string', array('limit' => 100, 'null' => false))
            ->create();

        // create table user visit tests
        $table = $this->table("user_visit_tests", array('id' => false, 'primary_key' => 'row_id'));
        $table->addColumn('row_id', 'string', array('length' => 100, 'null' => false))
            ->addColumn('created_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('created', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('last_upd_by', 'string', array('length' => 100, 'null' => true, 'default' => null))
            ->addColumn('last_upd', 'datetime', array('null' => true, 'default' => null))
            ->addColumn('deleted', 'integer', array('null' => false, 'limit' => 11, 'default' => 0))
            ->addColumn('user_visit_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('user_visit_id', 'user_visit', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('lab_test_id', 'string', array('limit' => 100, 'null' => true, 'default' => null))
            ->addForeignKey('lab_test_id', 'lab_test', array('row_id'), array('delete' => 'SET_NULL', 'update' => 'NO_ACTION'))
            ->addColumn('actual_value', 'string', array('limit' => 100, 'null' => true))
            ->addColumn('comments', 'text', array('null' => true))
            ->create();
    }
}
