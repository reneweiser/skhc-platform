<?php

namespace Database\Seeders;

use App\Models\ShirtSize;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ShirtSizeSeeder extends Seeder
{
    public function run()
    {
        $shirtSizes = ['xs', 's', 'm', 'l', 'xl', 'xxl', 'xxxl'];

        foreach ($shirtSizes as $size) ShirtSize::create(['name' => $size]);
    }
}
