<?php

use Illuminate\Database\Seeder;
use App\User;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(User::class)->create([
            'name' => 'tom',
                    'email' => 'admin@gmail.com',
                    'password' => bcrypt('1111'),
                    'featured' => 'https://bootdey.com/img/Content/avatar/avatar1.png'
        ]);

        factory(User::class)->create([
            'name' => 'jane',
            'email' => 'jane@gmail.com',
            'password' => bcrypt('1111'),
            'featured' => 'https://bootdey.com/img/Content/avatar/avatar6.png'
        ]);

        factory(User::class)->create([
            'name' => 'ken',
            'email' => 'ken@gmail.com',
            'password' => bcrypt('1111'),
            'featured' => 'https://bootdey.com/img/Content/avatar/avatar4.png'
        ]);
    }
}
