<?php

namespace Database\Seeders;

use App\Models\AttachmentInterface;
use App\Models\BodyZone;
use App\Models\Module;
use App\Models\ModuleType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $moduleTypes = ModuleType::all();
        $attachmentInterfaces = AttachmentInterface::all();
        $bodyZones = BodyZone::all();

        Module::factory()
            ->count(10)
            ->recycle([$moduleTypes, $attachmentInterfaces])
            ->state(fn (): array => [
                'body_zone_id' => $bodyZones->isNotEmpty() ? $bodyZones->random()->id : null,
            ])
            ->create();
    }
}
