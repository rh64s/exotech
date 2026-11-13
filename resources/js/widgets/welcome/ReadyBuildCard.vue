<script setup lang="ts">
withDefaults(
    defineProps<{
        /** Куда ведёт карточка готовой сборки. */
        href?: string;
        /** Путь к изображению экзоскелета. По умолчанию — прозрачная заглушка. */
        imageSrc?: string;
        /** Тип сборки: пассивный, активный, гибридный. */
        label: string;
        title: string;
        description: string;
        imageAlt: string;
    }>(),
    {
        href: '#',
        imageSrc:
            "data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E",
    },
);
</script>

<template>
    <article class="build-card">
        <div class="build-card__image">
            <img :src="imageSrc" :alt="imageAlt" />
        </div>
        <div class="build-card__body">
            <p class="build-card__label">{{ label }}</p>
            <h3 class="text-h3 build-card__title">{{ title }}</h3>
            <p class="build-card__description">{{ description }}</p>
            <a :href="href" class="build-card__link"> Посмотреть сборку → </a>
        </div>
    </article>
</template>

<style scoped>
.build-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 10px;
    border: 1px solid var(--color-disabled);
    border-radius: 18px;
    background-color: var(--color-surface);
    transition:
        transform 0.2s ease,
        box-shadow 0.2s ease;
}

.build-card:hover {
    transform: translateY(-2px);
    box-shadow: var(--shadow);
}

.build-card__image {
    height: 244px;
    overflow: hidden;
    border-radius: 10px;
    background-color: var(--color-image-placeholder);
}

.build-card__image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.build-card__body {
    display: flex;
    flex: 1;
    flex-direction: column;
    gap: 8px;
    padding: 14px;
}

.build-card__label {
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.4rem;
    text-transform: uppercase;
}

.build-card__title {
    line-height: 1.25;
}

.build-card__description {
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 1.8rem;
}

.build-card__link {
    margin-top: auto;
    color: var(--color-primary);
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 1.8rem;
    text-decoration: none;
    transition: color 0.2s ease;
}

.build-card__link:hover {
    color: var(--color-accent);
}
</style>
