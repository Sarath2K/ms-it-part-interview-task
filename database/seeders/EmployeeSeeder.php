<?php

namespace Database\Seeders;

use App\Models\User;
use Faker\Factory as Faker;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Run If Required
        // php artisan db:seed --class=EmployeeSeeder

        $faker = Faker::create('en_IN');

        for ($i = 1; $i <= 10; $i++) {
            $name = $faker->name;

            $randomMonth = $faker->numberBetween(1, 12);

            $randomDay = $faker->numberBetween(1, 28);

            $dob = now()->year($faker->year)->month($randomMonth)->day($randomDay);

            $user = User::create([
                'name' => $name,
                'unique_id' => User::getUserUniqueId(),
                'email' => Str::lower(str_replace(' ', '', $name)) . '@gmail.com',
                'status' => $faker->randomElement([STATUS_ACTIVE, STATUS_INACTIVE]),
                'phone' => $faker->phoneNumber,
                'gender' => $faker->randomElement([GENDER_MALE, GENDER_FEMALE]),
                'dob' => $dob,
                'address' => $faker->address,
                'password' => Hash::make('password')
            ]);

            $user->assignRole(ROLE_EMPLOYEE);
        }
    }
}
