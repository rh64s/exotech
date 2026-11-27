<?php

namespace Database\Seeders;

use Database\Seeders\MoreRealistic\AttachmentInterfaceSeeder;
use Database\Seeders\MoreRealistic\BodyZoneSeeder;
use Database\Seeders\MoreRealistic\CharacteristicSeeder;
use Database\Seeders\MoreRealistic\ChatSeeder;
use Database\Seeders\MoreRealistic\MessageSeeder;
use Database\Seeders\MoreRealistic\ModuleCharacteristicSeeder;
use Database\Seeders\MoreRealistic\ModuleSeeder;
use Database\Seeders\MoreRealistic\ModuleTypeSeeder;
use Database\Seeders\MoreRealistic\OrderSeeder;
use Database\Seeders\MoreRealistic\RoleSeeder;
use Database\Seeders\MoreRealistic\SchemeModuleSeeder;
use Database\Seeders\MoreRealistic\SchemeSeeder;
use Database\Seeders\MoreRealistic\UserSeeder;
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
            ModuleTypeSeeder::class,
            BodyZoneSeeder::class,
            AttachmentInterfaceSeeder::class,
            CharacteristicSeeder::class,
            ModuleSeeder::class,
            ModuleCharacteristicSeeder::class,
            ChatSeeder::class,
            MessageSeeder::class,
            SchemeSeeder::class,
            SchemeModuleSeeder::class,
            OrderSeeder::class,
        ]);
    }
}
