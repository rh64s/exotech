<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import { ref } from 'vue';
import Button from '@/shared/ui/Button.vue';
import {
    ConfiguratorPreview,
    ReadyBuildCard,
    SupportTypeCard,
} from '@/widgets/welcome';
import CatalogSearch from '@/assets/svg/CatalogSearch.vue';

type Task = {
    index: string;
    title: string;
    description: string;
};

type ReadyBuild = {
    href: string;
    imageSrc?: string;
    label: string;
    title: string;
    description: string;
    imageAlt: string;
};

type SupportType = {
    index: string;
    label: string;
    title: string;
    subtitle: string;
    description: string;
    note: string;
    featured?: boolean;
};

const tasks: Task[] = [
    {
        index: '01',
        title: 'Под вашу задачу',
        description: 'Работа, движение, исследования',
    },
    {
        index: '02',
        title: 'Модульная система',
        description: 'Выбирайте нужные зоны поддержки',
    },
    {
        index: '03',
        title: 'От идеи к прототипу',
        description: 'Сохраняйте и сравнивайте сборки',
    },
];

const catalogFilters = [
    'Все сборки',
    'Для работы',
    'Для движения',
    'Для исследований',
];

const activeFilter = ref(catalogFilters[0]);

const readyBuilds: ReadyBuild[] = [
    {
        href: '#',
        label: 'Пассивный',
        title: 'Поддержка в работе',
        description: 'Плечи и спина · без электропривода',
        imageAlt: 'Экзоскелет для поддержки в работе',
    },
    {
        href: '#',
        label: 'Активный',
        title: 'Поддержка движения',
        description: 'Нижняя часть тела · электропривод',
        imageAlt: 'Экзоскелет для поддержки движения',
    },
    {
        href: '#',
        label: 'Гибридный',
        title: 'Основа для эксперимента',
        description: 'Комбинация модулей под вашу задачу',
        imageAlt: 'Гибридный экзоскелет для эксперимента',
    },
];

const supportTypes: SupportType[] = [
    {
        index: '01',
        label: 'Passive',
        title: 'Пассивный',
        subtitle: 'Механическая поддержка',
        description:
            'Пружины и упругие элементы помогают перераспределять нагрузку. Такая система не требует питания для привода.',
        note: 'Без электропривода',
    },
    {
        index: '02',
        label: 'Active',
        title: 'Активный',
        subtitle: 'Управляемое усилие',
        description:
            'Двигатели создают дополнительное усилие, а датчики помогают системе реагировать на движение пользователя.',
        note: 'Двигатели + датчики',
        featured: true,
    },
    {
        index: '03',
        label: 'Hybrid',
        title: 'Гибридный',
        subtitle: 'Сочетание подходов',
        description:
            'Объединяет пассивные элементы и активные модули для разных зон и сценариев использования.',
        note: 'Механика + электропривод',
    },
];
</script>

<template>
    <Head title="Главная" />

    <div class="welcome-page">
        <section class="welcome-hero-section">
            <div
                class="welcome-hero island island-gradient-light o-hidden relative"
            >
                <div class="welcome-hero__content">
                    <h1 class="text-h1 welcome-hero__title">
                        Экзоскелет<br />под вашу задачу.
                    </h1>
                    <p class="text-p welcome-hero__text">
                        Соберите свой экзоскелет или выберите готовую сборку.<br />
                        Сохраняйте прототипы и возвращайтесь к своим идеям.
                    </p>
                    <div class="welcome-hero__actions">
                        <Button href="#" external>Собрать экзоскелет</Button>
                        <a href="#" class="text-link">Смотреть каталог →</a>
                    </div>
                </div>

                <div class="welcome-hero__image">
                    <img
                        src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                        alt="Человек в экзоскелете, его руки поднимают тяжёлый груз"
                    />
                </div>
            </div>

            <div class="welcome-tasks">
                <div
                    v-for="task in tasks"
                    :key="task.index"
                    class="welcome-tasks__item"
                >
                    <p class="welcome-tasks__index">{{ task.index }}</p>
                    <div class="welcome-tasks__text">
                        <p class="text-h3 welcome-tasks__title">
                            {{ task.title }}
                        </p>
                        <p class="welcome-tasks__description">
                            {{ task.description }}
                        </p>
                    </div>
                </div>
            </div>
        </section>

        <section class="configurator island">
            <div class="configurator__grid">
                <div class="configurator__content">
                    <h2 class="text-h2 configurator__title">
                        Соберите свой<br />экзоскелет
                    </h2>
                    <p class="text-p configurator__text">
                        Выберите основу, тип поддержки и модули.<br />
                        Конфигуратор поможет проверить совместимость<br />
                        и сохранить сборку как прототип.
                    </p>
                    <Button href="#" external>Начать сборку</Button>
                </div>

                <ConfiguratorPreview />
            </div>
        </section>

        <section class="ready-builds">
            <div class="ready-builds__header">
                <div>
                    <h2 class="text-h2">Готовые сборки</h2>
                    <p class="text-p ready-builds__subtitle">
                        Готовые концепции, которые можно изучить и адаптировать
                        под себя.
                    </p>
                </div>
                <a href="#" class="text-link">Весь каталог →</a>
            </div>

            <div class="ready-builds__toolbar">
                <div class="catalog-filters">
                    <button
                        v-for="filter in catalogFilters"
                        :key="filter"
                        type="button"
                        class="catalog-filter"
                        :class="{
                            'catalog-filter_active': activeFilter === filter,
                        }"
                        :aria-pressed="activeFilter === filter"
                        @click="activeFilter = filter"
                    >
                        {{ filter }}
                    </button>
                </div>

                <label class="catalog-search">
                    <CatalogSearch></CatalogSearch>
                    <input
                        type="search"
                        placeholder="Найти сборку"
                        aria-label="Найти сборку"
                    />
                </label>
            </div>

            <div class="ready-builds__grid">
                <ReadyBuildCard
                    v-for="build in readyBuilds"
                    :key="build.title"
                    v-bind="build"
                />
            </div>

            <p class="ready-builds__note">
                Концепции сборок. Состав можно изменить в конфигураторе.
            </p>
        </section>

        <section class="support island">
            <div class="support__content">
                <h2 class="text-h2 support__title">
                    Какой экзоскелет вам подходит
                </h2>

                <div class="support__grid">
                    <SupportTypeCard
                        v-for="type in supportTypes"
                        :key="type.title"
                        v-bind="type"
                    />
                </div>
            </div>
        </section>

        <section class="help island">
            <div class="help__content">
                <h2 class="text-h2 help__title">Поможем<br />с выбором</h2>

                <div class="help__side">
                    <p class="text-p help__text">
                        Расскажите о своей задаче. Поможем разобраться<br />
                        в типах экзоскелетов и выбрать основу для сборки.
                    </p>
                    <Button href="#" external>Получить консультацию</Button>
                </div>
            </div>
        </section>
    </div>
</template>

<style scoped>
.welcome-page {
    display: flex;
    flex-direction: column;
    gap: 64px;
    width: 100%;
}

.welcome-hero-section {
    display: flex;
    flex-direction: column;
    gap: 64px;
}

.welcome-hero__content {
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 32px;
}

.welcome-hero__title {
    letter-spacing: -0.02em;
    line-height: 1.13;
}

.welcome-hero__text {
    max-width: 610px;
    color: var(--color-second);
    line-height: 1.6;
}

.welcome-hero__actions {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 24px;
}

.welcome-hero__image {
    width: 100%;
    aspect-ratio: 1;
    overflow: hidden;
    border-radius: 18px;
    background-color: var(--color-image-placeholder);
}

.welcome-hero__image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.text-link {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: var(--text-p);
    font-weight: 600;
    line-height: 1.4;
    text-decoration: none;
    transition: color 0.2s ease;
}

.text-link:hover {
    color: var(--color-accent);
}

.welcome-tasks {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    padding-top: 40px;
    border-top: 1px solid var(--color-disabled);
}

.welcome-tasks__item {
    display: flex;
    gap: 24px;
    padding: 0 32px;
}

.welcome-tasks__item:first-child {
    padding-left: 0;
}

.welcome-tasks__item:last-child {
    padding-right: 0;
}

.welcome-tasks__item + .welcome-tasks__item {
    border-left: 1px solid var(--color-disabled);
}

.welcome-tasks__index {
    padding-top: 4px;
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4rem;
}

.welcome-tasks__title {
    line-height: 1.3;
}

.welcome-tasks__description {
    margin-top: 6px;
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 1.8rem;
}

.configurator__grid {
    display: grid;
    grid-column: 1 / -1;
    grid-template-columns: minmax(0, 1fr) 594px;
    gap: 48px;
    align-items: center;
}

.configurator__content {
    display: flex;
    max-width: 620px;
    flex-direction: column;
    gap: 24px;
}

.configurator__title {
    line-height: 1.17;
}

.configurator__text {
    color: var(--color-second);
    line-height: 1.55;
}

.ready-builds {
    display: flex;
    flex-direction: column;
    gap: 24px;
}

.ready-builds__header {
    display: flex;
    align-items: flex-end;
    justify-content: space-between;
    gap: 24px;
}

.ready-builds__subtitle {
    margin-top: 16px;
    color: var(--color-second);
}

.ready-builds__toolbar {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 24px;
}

.ready-builds__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
}

.ready-builds__note {
    color: var(--color-second);
    font-size: 1.2rem;
    line-height: 1.6rem;
}

.catalog-filters {
    display: flex;
    flex-wrap: wrap;
    gap: 8px;
}

.catalog-filter {
    display: inline-flex;
    align-items: center;
    height: 40px;
    padding: 0 18px;
    border: 0;
    border-radius: 20px;
    background-color: #eaf1f4;
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.3rem;
    font-weight: 500;
    line-height: 1.7rem;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.catalog-filter:hover {
    background-color: var(--color-accent);
    color: var(--color-text-light);
}

.catalog-filter_active {
    background-color: var(--color-accent);
    color: var(--color-text-light);
}

.catalog-search {
    display: flex;
    width: 312px;
    height: 40px;
    align-items: center;
    gap: 12px;
    padding: 0 16px;
    border: 1px solid var(--color-disabled);
    border-radius: 20px;
    background-color: var(--color-surface);
    color: var(--color-second);
}

.catalog-search svg {
    flex: none;
}

.catalog-search input {
    width: 100%;
    border: 0;
    background: transparent;
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.3rem;
    line-height: 1.7rem;
    outline: none;
}

.catalog-search input::placeholder {
    color: var(--color-second);
}

.support__content {
    grid-column: 1 / -1;
}

.support__title {
    line-height: 1.2;
}

.support__grid {
    display: grid;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 24px;
    margin-top: 32px;
}

.help__content {
    display: grid;
    grid-column: 1 / -1;
    grid-template-columns: minmax(0, 1fr) minmax(0, 1fr);
    gap: 64px;
    align-items: center;
}

.help__title {
    line-height: 1.15;
}

.help__side {
    display: flex;
    flex-direction: column;
    align-items: flex-start;
    gap: 24px;
}

.help__text {
    color: var(--color-primary);
    line-height: 1.5;
}
</style>
