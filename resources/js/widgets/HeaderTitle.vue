<script setup lang="ts">
withDefaults(
    defineProps<{
        title?: string;
        description?: string;
    }>(),
    {
        title: 'Название страницы',
        description:
            'Ну и описание страницы.',
    },
);
</script>

<template>
    <header class="header-title">
        <h1 class="header-title__title">{{ title }}</h1>
        <p class="header-title__description">{{ description }}</p>
    </header>
</template>
<style scoped>

.header-title {
    display: flex;
    flex-direction: column;
    gap: 1.6rem;
    width: 100%;
}

.header-title__title {
    color: var(--color-primary);
    font-size: 6rem;
    font-weight: 500;
    letter-spacing: -0.02em;
    line-height: 1.13;
}

.header-title__description {
    max-width: 70rem;
    color: var(--color-second);
    font-family: 'Manrope', 'Arial';
    font-size: 1.6rem;
    font-weight: 400;
    line-height: 2.6rem;
}

@media (max-width: 900px) {
    .header-title__title {
        font-size: 4rem;
        line-height: 1.15;
    }
}

</style>