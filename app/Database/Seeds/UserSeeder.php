<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'name' => 'Admin',
                'email' => 'admin@gmail.com',
                'password' => password_hash('admin123', PASSWORD_DEFAULT),
                'role' => 'admin',
            ],
                        [
                'name' => 'Editor',
                'email' => 'editor@gmail.com',
                'password' => password_hash('editor123', PASSWORD_DEFAULT),
                'role' => 'editor',
            ],
                        [
                'name' => 'Writer',
                'email' => 'writer@gmail.com',
                'password' => password_hash('writer123', PASSWORD_DEFAULT),
                'role' => 'writer',
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
