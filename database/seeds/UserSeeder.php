<?php

use Illuminate\Database\Seeder;
use App\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([

            'id'=>'1',
            'name'=>'Fernando',
            'cedula' => '0706829116',
            'edad' => 25,
            'apellidos'=>'Castillo',
            'estado'=> 1,
            'email'=> 'fernando@gmail.com',
            'password'=> bcrypt('12345678'),
            'email_verified_at'=>"2019-04-01 12:31:15",

        ]);
    }
}
