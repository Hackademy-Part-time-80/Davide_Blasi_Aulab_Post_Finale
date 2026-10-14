<?php

namespace Database\Seeders;

use App\Models\Category;
use App\Models\Role;
use Illuminate\Database\Seeder;

class RolesAndCategoriesSeeder extends Seeder
{
    public function run(): void
    {
        foreach (['Admin', 'Revisor', 'Writer'] as $name) {
            Role::firstOrCreate(['name' => $name]);
        }

        foreach (['Tecnologia', 'Business', 'Ambiente', 'Cultura', 'Scienza', 'Salute', 'Lifestyle', 'Sport'] as $name) {
            Category::firstOrCreate(['name' => $name]);
        }
    }
}