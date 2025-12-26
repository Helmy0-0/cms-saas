<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateArticlesTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'auto_increment'    => true,
            ],
            'title' => [
                'type'              => 'VARCHAR',
                'constraint'        => 255,
            ],
            'slug' => [
                'type'              => 'VARCHAR',
                'constraint'        => 200,
                'unique'            => true
            ],
            'content' => [
                'type'              => 'TEXT',
            ],
            'status' => [
                'type'              => 'ENUM',
                'constraint'        => ['draft', 'review', 'published'],
                'default'           => 'draft',
            ],
            'author_id' => [
                'type'              => 'INT',
                'unsigned'          => true,
            ],
            'approved_by' => [
                'type'              => 'INT',
                'unsigned'          => true,
                'null'              => true,
            ],
            'publish_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
            'created_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
                'updated_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
                'deleted_at' => [
                'type'              => 'DATETIME',
                'null'              => true,
            ],
        ]);
        
        $this->forge->addKey('id', true);
        $this->forge->addForeignKey('author_id', 'users', 'id');
        $this->forge->addForeignKey('approved_by', 'users', 'id');
        $this->forge->createTable('articles');
    }

    public function down()
    {
        $this->forge->dropTable('articles');
    }
}
