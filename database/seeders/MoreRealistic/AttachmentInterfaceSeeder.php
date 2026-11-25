<?php

namespace Database\Seeders\MoreRealistic;

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
            $name = match ($type) {
                AttachmentInterfaceType::Mechanical => 'Монтажная рейка М6',
                AttachmentInterfaceType::Electrical => 'Разъём питания и данных 24 В',
                AttachmentInterfaceType::Other => 'Текстильная петля 40 мм',
            };
            AttachmentInterface::updateOrCreate(['name' => $name], ['type' => $type]);
        }
    }
}
