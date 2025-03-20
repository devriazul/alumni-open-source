<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class StudentFactory extends Factory
{
    public function definition(): array
    {
        $departments = ['CSE', 'EEE', 'Civil', 'Mechanical', 'Architecture'];
        $bloodGroups = ['A+', 'A-', 'B+', 'B-', 'O+', 'O-', 'AB+', 'AB-'];
        $employmentStatus = ['Employed', 'Unemployed', 'Student', 'Self-Employed'];
        $sessions = ['2018-19', '2019-20', '2020-21', '2021-22', '2022-23'];

        return [
            'name' => fake()->name(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => fake()->phoneNumber(),
            'photo' => 'https://api.dicebear.com/7.x/avataaars/svg?seed=' . fake()->uuid(),
            'blood_group' => fake()->randomElement($bloodGroups),
            'session' => fake()->randomElement($sessions),
            'department' => fake()->randomElement($departments),
            'gender' => fake()->randomElement(['Male', 'Female']),
            'present_address' => fake()->address(),
            'permanent_address' => fake()->address(),
            'employment_status' => fake()->randomElement($employmentStatus),
            'company_name' => fake()->company(),
            'position' => fake()->jobTitle(),
            'additional_info' => json_encode([
                'skills' => fake()->words(3),
                'interests' => fake()->words(2),
                'social_links' => [
                    'linkedin' => 'https://linkedin.com/' . fake()->userName(),
                    'github' => 'https://github.com/' . fake()->userName(),
                ]
            ]),
            'created_at' => fake()->dateTimeBetween('-2 years'),
            'updated_at' => fake()->dateTimeBetween('-1 year')
        ];
    }
}