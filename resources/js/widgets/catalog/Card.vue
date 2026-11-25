<script setup lang="ts">
import { computed } from 'vue';
import { formatPrice, type CatalogModule } from './modules';

const props = defineProps<{
    module: CatalogModule;
}>();

const characteristics = computed(() =>
    props.module.characteristics.filter((characteristic) => characteristic.value?.trim()),
);

const price = computed(() => `${formatPrice(props.module.price)} ₽`);
</script>

<template>
    <article class="module-card">
        <div class="module-card__image">
            <img
                v-if="props.module.image_url"
                :src="props.module.image_url"
                :alt="props.module.name"
                loading="lazy"
            />
            <svg
                v-else
                class="module-card__placeholder"
                viewBox="0 0 48 48"
                fill="none"
                aria-hidden="true"
            >
                <rect
                    x="9"
                    y="13"
                    width="30"
                    height="22"
                    rx="5"
                    stroke="currentColor"
                    stroke-width="1.5"
                />
                <path
                    d="M9 21h30M18 13v22M30 13v22"
                    stroke="currentColor"
                    stroke-width="1.5"
                />
            </svg>
        </div>

        <div class="module-card__content">
            <div class="module-card__main">
                <p v-if="module.module_type.category" class="module-card__category">
                    {{ module.module_type.category.name }}
                </p>
                <h3 class="module-card__title">{{ props.module.name }}</h3>
                <p class="module-card__description">
                    {{ props.module.description }}
                </p>

                <div class="module-card__badges">
                    <span class="module-card__badge">
                        Тип: {{ module.module_type.name }}
                    </span>
                    <span v-if="module.body_zone" class="module-card__badge">
                        Зона: {{ module.body_zone.name }}
                    </span>
                    <span
                        v-for="characteristic in characteristics"
                        :key="characteristic.id"
                        class="module-card__badge"
                    >
                        {{ characteristic.name }}: {{ characteristic.value.trim() }}
                        {{ characteristic.unit }}
                    </span>
                </div>
            </div>

            <div class="module-card__footer">
                <div class="module-card__divider"></div>
                <div class="module-card__price-row">
                    <p class="module-card__price">{{ price }}</p>
                    <button type="button" class="module-card__link">
                        Подробнее
                        <span class="module-card__arrow" aria-hidden="true">
                            →
                        </span>
                    </button>
                </div>
            </div>
        </div>
    </article>
</template>

<style scoped>
.module-card {
    display: flex;
    gap: 2rem;
    width: 100%;
    min-height: 19.6rem;
    padding: 1.6rem;
    border: 1px solid var(--color-disabled);
    border-radius: 1.8rem;
    background-color: var(--color-surface);
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.module-card:hover {
    border-color: var(--color-stroke-soft);
    box-shadow: var(--shadow);
}

.module-card__image {
    display: grid;
    flex: none;
    width: 20rem;
    height: 16.4rem;
    place-items: center;
    overflow: hidden;
    border-radius: 1.2rem;
    background-color: var(--color-image-placeholder);
}

.module-card__image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.module-card__placeholder {
    width: 4.8rem;
    height: 4.8rem;
    color: var(--color-stroke-soft);
}

.module-card__content {
    display: flex;
    flex: 1;
    min-width: 0;
    flex-direction: column;
    justify-content: space-between;
    gap: 1.6rem;
}

.module-card__main {
    display: flex;
    flex-direction: column;
    gap: 0.8rem;
}

.module-card__category {
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.4rem;
    text-transform: uppercase;
}

.module-card__title {
    display: -webkit-box;
    overflow: hidden;
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 2.2rem;
    font-weight: 500;
    line-height: 2.8rem;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
}

.module-card__description {
    display: -webkit-box;
    overflow: hidden;
    color: var(--color-second);
    font-family: 'Manrope', 'Arial';
    font-size: 1.4rem;
    font-weight: 400;
    line-height: 1.8rem;
    -webkit-box-orient: vertical;
    -webkit-line-clamp: 1;
}

.module-card__badges {
    display: flex;
    flex-wrap: wrap;
    gap: 0.6rem;
}

.module-card__badge {
    display: inline-flex;
    height: 2.4rem;
    align-items: center;
    padding: 0 1rem;
    border-radius: 1.2rem;
    background-color: var(--color-chip);
    color: var(--color-accent);
    font-size: 1.1rem;
    font-weight: 500;
    line-height: 1.4rem;
}

.module-card__footer {
    display: flex;
    flex-direction: column;
    gap: 1.2rem;
}

.module-card__divider {
    width: 100%;
    height: 1px;
    background-color: var(--color-disabled);
}

.module-card__price-row {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.6rem;
}

.module-card__price {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.8rem;
    font-weight: 600;
    line-height: 2.4rem;
}

.module-card__link {
    display: inline-flex;
    align-items: center;
    gap: 0.4rem;
    border: 0;
    background: transparent;
    color: var(--color-accent);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.3rem;
    font-weight: 600;
    line-height: 1.8rem;
    cursor: pointer;
    transition: color 0.2s ease;
}

.module-card__link:hover {
    color: var(--color-hover);
}

.module-card__arrow {
    font-size: 1.5rem;
    line-height: 1;
}

@media (max-width: 768px) {
    .module-card {
        flex-direction: column;
        gap: 1.4rem;
        padding: 1.2rem;
    }

    .module-card__image {
        width: 100%;
        height: 18rem;
    }

    .module-card__title {
        font-size: 2rem;
        line-height: 2.6rem;
    }
}
</style>
