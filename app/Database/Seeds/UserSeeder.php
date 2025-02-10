<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class UserSeeder extends Seeder {
    public function run() {
        $data = [
            [
                'first_name'   => 'Admin',
                'last_name'    => 'User',
                'email'        => 'admin@example.com',
                'password'     => password_hash('password', PASSWORD_DEFAULT),
                'role'         => 'admin',
                'profile_image'=> null,
            ],
            [
                'first_name'   => 'John',
                'last_name'    => 'Doe',
                'email'        => 'john@example.com',
                'password'     => password_hash('password', PASSWORD_DEFAULT),
                'role'         => 'customer',
                'profile_image'=> null,
            ],
        ];

        $this->db->table('users')->insertBatch($data);
    }
}
