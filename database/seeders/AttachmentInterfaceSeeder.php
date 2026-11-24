<?php

namespace Database\Seeders;

use App\Enums\AttachmentInterfaceType;
use App\Models\AttachmentInterface;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AttachmentInterfaceSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        foreach (AttachmentInterfaceType::cases() as $type) {
            AttachmentInterface::factory()
                ->ofType($type)
                ->create();
        }
    }
}
