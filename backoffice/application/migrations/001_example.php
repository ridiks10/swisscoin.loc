<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Migration_Example extends CI_Migration {

    public function up()
    {
        # example up (create table)

//        $this->dbforge->add_field('id');
//        $this->dbforge->create_table('example_table');

    }

    public function down()
    {
        # example down (drop table)

//        $this->dbforge->drop_table('example_table');

    }
}