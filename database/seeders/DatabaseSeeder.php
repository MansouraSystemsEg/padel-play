<?php

namespace Database\Seeders;

use App\Models\Court;
use App\Models\Region;
use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Database\Eloquent\Factories\Sequence;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::truncate();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
        ]);

        User::factory(100)->create();

        Region::truncate();
        Court::truncate();

        Region::factory()
            ->has(
                Region::factory()
                    ->count(20)
                    ->has(
                        Court::factory()
                            ->count(30)
                            ->state(new Sequence(
                                fn(Sequence $sequence) => [
                                    'manager_id' => User::inRandomOrder()->first()->id,
                                ],
                            ))
                    )
                    ->state(new Sequence(
                        fn(Sequence $sequence) => [
                            'manager_id' => User::inRandomOrder()->first()->id,
                        ],
                    ))
                ,
                'children'
            )
            ->state(new Sequence(
                fn(Sequence $sequence) => [
                    'manager_id' => User::inRandomOrder()->first()->id,
                ],
            ))
            ->count(10)
            ->create();
    }
}
