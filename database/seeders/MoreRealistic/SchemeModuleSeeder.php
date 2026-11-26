<?php

namespace Database\Seeders\MoreRealistic;

use App\Http\Services\SchemeService;
use App\Models\Module;
use App\Models\Scheme;
use Illuminate\Database\Seeder;

class SchemeModuleSeeder extends Seeder
{
    public function run(SchemeService $assembly): void
    {
        $scheme = Scheme::where('name', 'Поддержка в работе')->where('official', true)->sole();
        $pocket = Module::where('name', 'Карман для инструмента')->sole();
        $slot = $scheme->frame->slots()->where($pocket->only('body_zone_id', 'attachment_interface_id'))->sole();
        $scheme->installations()->delete();
        for ($i = 0; $i < 2; $i++) {
            $assembly->install($scheme, $slot->id, $pocket->id);
        }
    }
}
