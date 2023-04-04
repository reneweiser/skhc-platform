<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            ShirtSizeSeeder::class,
            EventSeeder::class,
        ]);

        User::factory()->create([
            'name' => 'SKHC',
            'email' => 'skhc@kulturtragwerk.de',
            'password' => bcrypt(Str::random(50)),
        ]);
    }
}
