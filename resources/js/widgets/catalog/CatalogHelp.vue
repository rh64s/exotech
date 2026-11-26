<script setup lang="ts">
import { Button } from '@/shared/ui';
</script>

<template>
    <aside class="catalog-help">
        <div class="catalog-help__text">
            <h2 class="catalog-help__title">Не нашли нужный модуль?</h2>
            <p class="catalog-help__description">
                Нажмите «Собрать» на карточке каркаса — конфигуратор покажет подходящие аксессуары.<br />
                Вы можете также спросить наших экспертов.
            </p>
        </div>

        <div class="catalog-help__actions">
            <Button variant="ghost" class="catalog-help__ask">
                Спросить
            </Button>
        </div>
    </aside>
</template>

<style scoped>
.catalog-help {
    display: flex;
    width: 100%;
    align-items: center;
    justify-content: space-between;
    gap: 3.2rem;
    padding: 3.2rem 4.2rem;
    border-radius: 2.4rem;
    background-color: var(--color-surface);
}

.catalog-help__text {
    display: flex;
    flex: 1;
    min-width: 0;
    max-width: 58rem;
    flex-direction: column;
    gap: 0.8rem;
}

.catalog-help__title {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 2.8rem;
    font-weight: 500;
    line-height: 3.6rem;
}

.catalog-help__description {
    color: var(--color-second);
    font-family: 'Manrope', 'Arial';
    font-size: 1.5rem;
    font-weight: 400;
    line-height: 2.4rem;
}

.catalog-help__actions {
    display: flex;
    flex: none;
    flex-wrap: nowrap;
    align-items: center;
    gap: 2rem;
}

.catalog-help__ask,
.catalog-help__cta {
    height: 5.4rem;
    padding: 1.2rem 2.4rem;
    border-radius: 1rem;
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.5rem;
    font-weight: 600;
    line-height: 2rem;
}

.catalog-help__ask {
    background-color: var(--color-chip);
    color: var(--color-accent);
}

.catalog-help__ask:hover {
    background-color: var(--color-accent);
    color: var(--color-text-light);
}

@media (max-width: 1200px) {
    .catalog-help {
        align-items: flex-start;
        flex-direction: column;
        gap: 2.4rem;
        padding: 2.4rem;
    }
}
</style>
