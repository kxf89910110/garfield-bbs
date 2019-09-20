<?php

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get a Faker instance
        $faker = app(Faker\Generator::class);

        // Avatar fake data
        $avatars = [
            'https://pic1.zhimg.com/v2-4c7e350e627ac0ddac40e3cd5766d42c_r.jpg',

            'https://pic2.zhimg.com/v2-64f436d9077e502a973279409b1feea5_r.jpg',

            'https://pic2.zhimg.com/v2-5f7c00c4b1687de2e320f5629910402d_r.jpg',

            'https://pic4.zhimg.com/80/v2-65da9bccd3d71baad0c82bc2d73d3e9b_hd.jpg',

            'https://pic4.zhimg.com/80/v2-0d1124be717f26f337ed69985ce16927_hd.jpg',

            'https://pic4.zhimg.com/80/v2-58ce894dbaf02d1572c8c163b6aaa74f_hd.jpg'
        ];

        // Generating data sets
        $users = factory(User::class)
                        ->times(10)
                        ->make()
                        ->each(function ($user, $index)
                            use ($faker, $avatars)
        {
            // Randomly take one from the avatar array and assign it
            $user->avatar = $faker->randomElement($avatars);
        });

        // Make hidden fields visible and convert data collections to arrays
        $user_array = $users->makeVisible(['password', 'remember_token'])->toArray();

        // Insert into the database
        User::insert($user_array);

<<<<<<< HEAD
        // Initialize the user role and assign user number 1 as 'master'
        // $user = User::find(2);
        // $user->assignRole('Founder');

        // Assign User #2 as 'Administrator'
        // $user = User::find(1);
        // $user->assignRole('Maintainer');
=======
        // Initiallize the user role and assign user number 1 as "master"
        $user = User::find(1);
        $user->assignRole('Founder');

        // Assign User #2 as "Administrator"
        $user = User::find(2);
        $user->assignRole('Maintainer');
>>>>>>> L03_5.8
    }
}
