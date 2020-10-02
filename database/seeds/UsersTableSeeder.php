<?php

use App\User;
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
        $user = User::updateOrCreate(
            ['email' => 'jebauza@gmail.com'],
            [
                'firstname' => 'Jorge',
                'secondname' => 'Ernesto',
                'lastname' => 'Bauza Becerra',
                'username' => 'jebauza',
                'email_verified_at' => now(),
                'password' => '$2y$10$RH/Uxs8A3Pn/TR3ghcLzbOM6UIPNFISybQD9JvX4luEL2wso9/J2S', // secret
                'remember_token' => Str::random(10),
                'created_by' => 1,
                'updated_by' => 1,
            ]
        );
        factory(User::class, 20)->create();
    }
}
