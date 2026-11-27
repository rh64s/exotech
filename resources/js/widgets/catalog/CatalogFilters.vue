<script setup lang="ts">
import { computed, ref, watch } from 'vue';
import {
    formatPrice,
    type CatalogFilterState,
    type CharacteristicFilterOption,
    type FilterOption,
} from './modules';

const props = defineProps<{
    bodyZones?: FilterOption[];
    frameLimits?: boolean;
    types: FilterOption[];
    characteristicOptions: CharacteristicFilterOption[];
    priceMin: number;
    priceMax: number;
    filters: CatalogFilterState;
}>();

const emit = defineEmits<{
    'update:filters': [filters: CatalogFilterState];
}>();

const minPrice = ref(props.filters.min_price ?? props.priceMin);
const maxPrice = ref(props.filters.max_price ?? props.priceMax);

watch(
    () => props.filters,
    (filters) => {
        minPrice.value = filters.min_price ?? props.priceMin;
        maxPrice.value = filters.max_price ?? props.priceMax;
    },
);

const priceLabel = computed(
    () => `${formatPrice(minPrice.value)} — ${formatPrice(maxPrice.value)} ₽`,
);

function toggleFilter(
    key: 'body_zones' | 'types' | 'characteristic_values',
    id: number,
): void {
    const values = props.filters[key] ?? [];
    const selected = values.includes(id)
        ? values.filter((value) => value !== id)
        : [...values, id];

    emit('update:filters', {
        ...props.filters,
        [key]: selected,
    });
}

function applyPrice(): void {
    const requestedMin = typeof minPrice.value === 'number' ? minPrice.value : props.priceMin;
    const requestedMax = typeof maxPrice.value === 'number' ? maxPrice.value : props.priceMax;
    const min = Math.max(props.priceMin, Math.min(requestedMin, props.priceMax));
    const max = Math.max(min, Math.min(requestedMax, props.priceMax));

    minPrice.value = min;
    maxPrice.value = max;

    emit('update:filters', {
        ...props.filters,
        min_price: min === props.priceMin ? null : min,
        max_price: max === props.priceMax ? null : max,
    });
}

function applyWeight(
    key: 'max_weight_g' | 'min_total_weight_g',
    event: Event,
): void {
    const input = event.target as HTMLInputElement;

    if (!input.reportValidity()) {
        return;
    }

    emit('update:filters', {
        ...props.filters,
        [key]: input.value === '' ? null : input.valueAsNumber,
    });
}

function resetFilters(): void {
    minPrice.value = props.priceMin;
    maxPrice.value = props.priceMax;

    emit('update:filters', {
        body_zones: [],
        types: [],
        characteristic_values: [],
        min_price: null,
        max_price: null,
    });
}
</script>

<template>
    <aside class="catalog-filters" aria-label="Фильтры каталога">
        <div class="catalog-filters__header">
            <h2 class="catalog-filters__title">Фильтры</h2>
            <button
                type="button"
                class="catalog-filters__reset"
                aria-label="Сбросить фильтры"
                @click="resetFilters"
            >
                Сбросить фильтры
            </button>
        </div>

        <div class="catalog-filters__divider"></div>

        <div class="catalog-filters__groups">
            <fieldset v-if="types.length" class="catalog-filters__group">
                <legend class="catalog-filters__label">Тип</legend>

                <div class="catalog-filters__chips">
                    <button
                        v-for="type in types"
                        :key="type.id"
                        type="button"
                        class="catalog-filters__chip"
                        :aria-pressed="filters.types.includes(type.id)"
                        @click="toggleFilter('types', type.id)"
                    >
                        {{ type.name }}
                    </button>
                </div>
            </fieldset>

            <fieldset v-if="bodyZones?.length" class="catalog-filters__group">
                <legend class="catalog-filters__label">Зона тела</legend>

                <div class="catalog-filters__chips">
                    <button
                        v-for="zone in bodyZones"
                        :key="zone.id"
                        type="button"
                        class="catalog-filters__chip"
                        :aria-pressed="filters.body_zones?.includes(zone.id) ?? false"
                        @click="toggleFilter('body_zones', zone.id)"
                    >
                        {{ zone.name }}
                    </button>
                </div>
            </fieldset>

            <fieldset class="catalog-filters__group">
                <legend class="catalog-filters__label">Цена, ₽</legend>

                <p class="catalog-filters__price-value">{{ priceLabel }}</p>

                <div class="catalog-filters__price-inputs">
                    <label>
                        <span>От</span>
                        <input
                            v-model.number="minPrice"
                            type="number"
                            step="any"
                            :min="priceMin"
                            :max="priceMax"
                            @change="applyPrice"
                        />
                    </label>
                    <label>
                        <span>До</span>
                        <input
                            v-model.number="maxPrice"
                            type="number"
                            step="any"
                            :min="priceMin"
                            :max="priceMax"
                            @change="applyPrice"
                        />
                    </label>
                </div>

                <div class="catalog-filters__bounds">
                    <span>{{ formatPrice(priceMin) }} ₽</span>
                    <span>{{ formatPrice(priceMax) }} ₽</span>
                </div>
            </fieldset>

            <fieldset v-if="frameLimits" class="catalog-filters__group">
                <legend class="catalog-filters__label">Масса и лимит сборки</legend>

                <div class="catalog-filters__price-inputs">
                    <label>
                        <span>Масса каркаса до, г</span>
                        <input
                            :value="filters.max_weight_g ?? ''"
                            type="number"
                            min="0"
                            step="1"
                            @change="applyWeight('max_weight_g', $event)"
                        />
                    </label>
                    <label>
                        <span>Лимит массы сборки от, г</span>
                        <input
                            :value="filters.min_total_weight_g ?? ''"
                            type="number"
                            min="0"
                            step="1"
                            @change="applyWeight('min_total_weight_g', $event)"
                        />
                    </label>
                </div>
            </fieldset>

            <fieldset
                v-for="characteristic in characteristicOptions"
                :key="characteristic.id"
                class="catalog-filters__group"
            >
                <legend class="catalog-filters__label">
                    {{ characteristic.name }}{{
                        characteristic.unit ? `, ${characteristic.unit}` : ''
                    }}
                </legend>

                <div class="catalog-filters__chips">
                    <button
                        v-for="value in characteristic.values"
                        :key="value.id"
                        type="button"
                        class="catalog-filters__chip"
                        :aria-pressed="filters.characteristic_values.includes(value.id)"
                        @click="toggleFilter('characteristic_values', value.id)"
                    >
                        {{ value.label }}
                    </button>
                </div>
            </fieldset>
        </div>
    </aside>
</template>

<style scoped>
.catalog-filters {
    display: flex;
    position: sticky;
    top: 80px;
    max-height: calc(100vh - 100px);
    overflow: hidden;
    flex: none;
    width: 32.8rem;
    flex-direction: column;
    gap: 2rem;
    padding: 2.4rem;
    border-radius: 2.4rem;
    background-color: var(--color-surface);
}

.catalog-filters__header,
.catalog-filters__divider {
    flex: none;
}

.catalog-filters__groups {
    min-height: 0;
    overflow-y: auto;
    overscroll-behavior-y: contain;
    scrollbar-gutter: stable;
}

.catalog-filters__header {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 2.4rem;
}

.catalog-filters__title {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.8rem;
    font-weight: 600;
    line-height: 2.4rem;
}

.catalog-filters__reset {
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

.catalog-filters__reset:hover {
    color: var(--color-hover);
}

.catalog-filters__divider {
    width: 100%;
    height: 1px;
    background-color: var(--color-disabled);
}

.catalog-filters__groups {
    display: flex;
    flex-direction: column;
    gap: 2.4rem;
}

.catalog-filters__group {
    display: flex;
    min-width: 0;
    flex-direction: column;
    gap: 1.6rem;
    margin: 0;
    padding: 0;
    border: 0;
}

.catalog-filters__label {
    padding: 0;
    color: var(--color-second);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.4rem;
    text-transform: uppercase;
}

.catalog-filters__chips {
    display: flex;
    flex-wrap: wrap;
    gap: 0.8rem;
}

.catalog-filters__chip {
    display: inline-flex;
    min-height: 3.4rem;
    max-width: 100%;
    align-items: center;
    justify-content: center;
    padding: 0.6rem 1.4rem;
    border: 0;
    border-radius: 1.7rem;
    background-color: var(--color-chip);
    color: var(--color-primary);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.3rem;
    font-weight: 500;
    line-height: 1.8rem;
    overflow-wrap: anywhere;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.catalog-filters__chip:hover,
.catalog-filters__chip[aria-pressed='true'] {
    background-color: var(--color-accent);
    color: var(--color-text-light);
}

.catalog-filters__price-value {
    color: var(--color-primary);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.3rem;
    font-weight: 500;
    line-height: 1.8rem;
}

.catalog-filters__price-inputs {
    display: flex;
    gap: 0.8rem;
}

.catalog-filters__price-inputs label {
    display: flex;
    min-width: 0;
    flex: 1;
    flex-direction: column;
    gap: 0.4rem;
    color: var(--color-second);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.2rem;
}

.catalog-filters__price-inputs input {
    width: 100%;
    min-width: 0;
    height: 3.4rem;
    padding: 0 0.8rem;
    border: 1px solid var(--color-disabled);
    border-radius: 0.8rem;
    background: var(--color-base);
    color: var(--color-primary);
    font: inherit;
}

.catalog-filters__bounds {
    display: flex;
    align-items: center;
    justify-content: space-between;
    gap: 1.6rem;
    color: var(--color-second);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.2rem;
    font-weight: 400;
    line-height: 1.6rem;
}

@media (max-width: 980px) {
    .catalog-filters {
        width: 100%;
        position: static;
    }
}
</style>
