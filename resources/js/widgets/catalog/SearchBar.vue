<script setup lang="ts">
import { ref, watch } from 'vue';
import CatalogSearch from '@/assets/svg/CatalogSearch.vue';

const props = withDefaults(
    defineProps<{
        placeholder?: string;
        label?: string;
        search: string;
    }>(),
    {
        placeholder: 'Найти модуль, например «привод колена»',
        label: 'Поиск по каталогу модулей',
    },
);

const emit = defineEmits<{ search: [query: string] }>();
const query = ref(props.search);
watch(
    () => props.search,
    (search) => {
        query.value = search;
    },
);
</script>

<template>
    <form
        class="catalog-search"
        role="search"
        @submit.prevent="emit('search', query.trim())"
    >
        <CatalogSearch />
        <input
            v-model="query"
            type="search"
            maxlength="100"
            :placeholder="placeholder"
            :aria-label="label"
        />
        <button type="submit">Найти</button>
    </form>
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
