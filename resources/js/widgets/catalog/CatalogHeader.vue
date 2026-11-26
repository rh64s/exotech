<script setup lang="ts">
withDefaults(
    defineProps<{
        title?: string;
        description?: string;
    }>(),
    {
        title: 'Каталог экзоскелетов',
        description:
            'Выберите заводской каркас, затем установите аксессуары на его свободные крепления.',
    },
);
</script>

<template>
    <header class="catalog-header">
        <h1 class="catalog-header__title">{{ title }}</h1>
        <p class="catalog-header__description">{{ description }}</p>
    </header>
</template>

<style scoped>
.catalog-header {
    display: flex;
    flex-direction: column;
    gap: 1.6rem;
    width: 100%;
}

.catalog-header__title {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 6rem;
    font-weight: 500;
    letter-spacing: -0.02em;
    line-height: 1.13;
}

.catalog-header__description {
    max-width: 70rem;
    color: var(--color-second);
    font-family: 'Manrope', 'Arial';
    font-size: 1.6rem;
    font-weight: 400;
    line-height: 2.6rem;
}

@media (max-width: 900px) {
    .catalog-header__title {
        font-size: 4rem;
        line-height: 1.15;
    }
}
</style>
