<script setup lang="ts">
withDefaults(
    defineProps<{
        index: string;
        label: string;
        title: string;
        subtitle: string;
        description: string;
        note: string;
        /** Выделенная карточка в середине блока. */
        featured?: boolean;
    }>(),
    {
        featured: false,
    },
);
</script>

<template>
    <article
        class="support-card"
        :class="{ 'support-card_featured': featured }"
    >
        <p class="support-card__label">{{ index }} / {{ label }}</p>
        <h3 class="text-h3 support-card__title">{{ title }}</h3>
        <p class="support-card__subtitle">{{ subtitle }}</p>
        <p class="support-card__description">{{ description }}</p>
        <div class="support-card__divider"></div>
        <p class="support-card__note">{{ note }}</p>
    </article>
</template>

<style scoped>
.support-card {
    display: flex;
    flex-direction: column;
    height: 100%;
    padding: 26px 24px 24px;
    border: 1px solid var(--color-disabled);
    border-radius: 18px;
    background-color: var(--color-surface);
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.support-card_featured {
    border-color: color-mix(
        in srgb,
        var(--color-accent) 22%,
        var(--color-disabled)
    );
    background-color: #eaf1f4;
    box-shadow: var(--shadow);
}

.support-card__label {
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.4rem;
    text-transform: uppercase;
}

.support-card__title {
    margin-top: 16px;
    line-height: 1.3;
}

.support-card__subtitle {
    margin-top: 8px;
    color: var(--color-primary);
    font-size: 1.5rem;
    font-weight: 600;
    line-height: 2rem;
}

.support-card__description {
    margin-top: 12px;
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 2.2rem;
}

.support-card__divider {
    height: 1px;
    margin-top: auto;
    margin-bottom: 20px;
    background-color: var(--color-disabled);
}

.support-card__note {
    color: var(--color-primary);
    font-size: 1.3rem;
    font-weight: 500;
    line-height: 1.7rem;
}
</style>
