<script setup lang="ts">
import { ref } from 'vue';
import CatalogSearch from '@/assets/svg/CatalogSearch.vue';

withDefaults(
    defineProps<{
        placeholder?: string;
    }>(),
    {
        placeholder: 'Найти модуль, например «привод колена»',
    },
);

const query = ref('');
</script>

<template>
    <label class="catalog-search">
        <CatalogSearch />
        <input
            v-model="query"
            type="search"
            :placeholder="placeholder"
            aria-label="Поиск по каталогу модулей"
        />
    </label>
</template>

<style scoped>
.catalog-search {
    display: flex;
    width: 100%;
    height: 5.4rem;
    align-items: center;
    gap: 1.2rem;
    padding: 0 2rem;
    border: 1px solid var(--color-disabled);
    border-radius: 2.7rem;
    background-color: var(--color-base);
    color: var(--color-second);
    transition: border-color 0.2s ease;
}

.catalog-search:focus-within {
    border-color: var(--color-stroke-soft);
}

.catalog-search svg {
    flex: none;
    width: 2rem;
    height: 2rem;
}

.catalog-search input {
    width: 100%;
    border: 0;
    background: transparent;
    color: var(--color-primary);
    font-family: 'Inter', 'Segoe UI', sans-serif;
    font-size: 1.5rem;
    font-weight: 400;
    line-height: 2rem;
    outline: none;
}

.catalog-search input::placeholder {
    color: var(--color-second);
}

.catalog-search input::-webkit-search-cancel-button {
    cursor: pointer;
}
</style>
