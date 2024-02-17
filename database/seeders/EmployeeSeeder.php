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
            $fName = $faker->name;
            $lName = $faker->name;

            $randomMonth = $faker->numberBetween(1, 12);

            $randomDay = $faker->numberBetween(1, 28);

            $dob = now()->year($faker->year)->month($randomMonth)->day($randomDay);

            $user = User::create([
                'employee_id' => User::getUserUniqueId(),
                'f_name' => $fName,
                'l_name' => $lName,
                'dob' => $dob,
                'edu_qualification' => $faker->randomElement(['MCA', 'MSc', 'BCA', 'BSc']),
                'gender' => $faker->randomElement([GENDER_MALE, GENDER_FEMALE]),
                'address' => $faker->address,
                'email' => Str::lower(str_replace(' ', '', $fName)) . '@gmail.com',
                'phone' => $faker->phoneNumber,
                'password' => Hash::make('password'),
                'created_at' => now()->month($randomMonth)->day($randomDay),
            ]);

            $user->assignRole(ROLE_EMPLOYEE);
        }
    }
}
