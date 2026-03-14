<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddCourseNameToUsers extends Migration
{
    public function up()
    {
        $this->forge->addColumn('users', [
            'course_name' => [
                'type'       => 'VARCHAR',
                'constraint' => 20,
                'null'       => true,
                'after'      => 'role',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('users', 'course_name');
    }
}
