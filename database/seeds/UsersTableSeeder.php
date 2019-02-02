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
            'password' => password_hash('admin1234', PASSWORD_BCRYPT)
        ]);
    }
}
