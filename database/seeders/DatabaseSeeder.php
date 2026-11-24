<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RoleSeeder::class,
            AdminSeeder::class,
            UserSeeder::class,
            ModuleCategorySeeder::class,
            ModuleTypeSeeder::class,
            BodyZoneSeeder::class,
            AttachmentInterfaceSeeder::class,
            CharacteristicSeeder::class,
            ModuleSeeder::class,
            CompatibleModuleSeeder::class,
            ModuleCharacteristicSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            SchemeSeeder::class,
            SchemeModuleSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
