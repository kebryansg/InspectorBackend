<?php

use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\User::class)->create([
            'name' => 'Administrador Test',
            'email' => 'admin@admin.com',
            'IDRol' => 0,
            'Estado' => 'ADM',
            'password' => password_hash('12345', PASSWORD_BCRYPT)
        ]);
    }
}
