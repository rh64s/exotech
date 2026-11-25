<?php

namespace Database\Seeders\MoreRealistic;

use App\Models\Module;
use App\Models\Scheme;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SchemeModuleSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $modules = Module::pluck('id', 'name');
        foreach ([
            'Поддержка в работе' => [
                'Рама «Смена»' => null,
                'Плечевой подвес ПП-40' => 'Рама «Смена»',
                'Поясничный упор ПУ-60' => 'Рама «Смена»',
            ],
            'Поддержка движения' => [
                'Рама «Шаг»' => null,
                'Коленный привод КП-90' => 'Рама «Шаг»',
                'Манжета голени МГ-2' => 'Коленный привод КП-90',
            ],
            'Основа для эксперимента' => [
                'Рама «Практикум»' => null,
                'Тазовый пояс ТП-1' => 'Рама «Практикум»',
                'Инерциальный датчик ИД-100' => 'Рама «Практикум»',
                'Датчик наклона ДН-50' => 'Рама «Практикум»',
            ],
        ] as $name => $assembly) {
            $scheme = Scheme::where('name', $name)->where('official', $name !== 'Основа для эксперимента')->firstOrFail();
            $placements = [];
            foreach ($assembly as $module => $parent) {
                $scheme->modules()->syncWithoutDetaching([$modules[$module] => [
                    'parent_scheme_modules_id' => $parent === null ? null : $placements[$parent],
                ]]);
                $placements[$module] = DB::table('scheme_modules')->where('scheme_id', $scheme->id)
                    ->where('module_id', $modules[$module])->value('id');
            }
        }
    }
}
