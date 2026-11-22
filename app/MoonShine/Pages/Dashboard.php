<?php

declare(strict_types=1);

namespace App\MoonShine\Pages;

use MoonShine\Contracts\UI\ComponentContract;
use MoonShine\Laravel\Pages\Page;
use MoonShine\MenuManager\Attributes\SkipMenu;

#[SkipMenu]

class Dashboard extends Page
{
    /**
     * @return array<string, string>
     */
    protected string $title = 'Главная';

    protected string $subtitle = 'Главная страница со всей необходимой информацией под рукой';

    public function getBreadcrumbs(): array
    {
        return [
            '#' => $this->getTitle(),
        ];
    }

    public function getTitle(): string
    {
        return $this->title ?: 'Dashboard';
    }

    public function getSubtitle(): string
    {
        return $this->subtitle ?: '';
    }

    /**
     * @return list<ComponentContract>
     */
    protected function components(): iterable
    {
        return [

        ];
    }
}
