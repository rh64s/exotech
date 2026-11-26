<script setup lang="ts">
import { Head, InfiniteScroll, Link, router } from "@inertiajs/vue3";
import { computed } from "vue";
import { catalog } from "@/routes";
import { index as schemes } from "@/routes/schemes";
import {
    Card,
    CatalogFilters,
    CatalogHeader,
    CatalogHelp,
    SearchBar,
    type CatalogModule,
    type ModuleCategory,
} from "@/widgets/catalog";

type PaginatedModules = {
    data: CatalogModule[];
};

type FilterOption = {
    id: number;
    name: string;
};

type CatalogFilterState = {
    body_zones: number[];
    types: number[];
    categories: number[];
    min_price: number | null;
    max_price: number | null;
};

const props = defineProps<{
    items: PaginatedModules;
    categories: ModuleCategory[];
    types: FilterOption[];
    body_zones: FilterOption[];
    min_price: string | number | null;
    max_price: string | number | null;
    filters: CatalogFilterState & { saved: boolean; interface: number | null };
}>();

const priceBounds = computed(() => {
    return {
        min: Number(props.min_price ?? 0),
        max: Number(props.max_price ?? 0),
    };
});

function updateFilters(
    filters: CatalogFilterState,
    saved = props.filters.saved,
    attachment = props.filters.interface,
): void {
    const query = {
        ...(saved && { saved: 1 }),
        ...(attachment && { interface: attachment }),
        ...(filters.body_zones.length > 0 && {
            body_zones: filters.body_zones,
        }),
        ...(filters.types.length > 0 && { types: filters.types }),
        ...(filters.categories.length > 0 && {
            categories: filters.categories,
        }),
        ...(filters.min_price !== null && { min_price: filters.min_price }),
        ...(filters.max_price !== null && { max_price: filters.max_price }),
    };

    router.get(catalog.url(), query, {
        preserveScroll: true,
        preserveState: true,
        replace: true,
    });
}
</script>

<template>
    <Head title="Каталог" />

    <div class="catalog-page">
        <CatalogHeader />
        <p v-if="$page.props.errors.scheme_limit" role="alert">
            {{ $page.props.errors.scheme_limit }}
            <Link :href="schemes()" class="underline">Мои схемы</Link>
        </p>
        <label v-if="$page.props.auth.user">
            <input
                type="checkbox"
                :checked="filters.saved"
                @change="updateFilters(filters, !filters.saved)"
            />
            Только сохранённые
        </label>
        <button
            v-if="filters.interface"
            type="button"
            class="text-left underline"
            @click="updateFilters(filters, filters.saved, null)"
        >
            Снять фильтр интерфейса крепления
        </button>

        <div class="catalog-page__layout">
            <CatalogFilters
                :body-zones="body_zones"
                :types="types"
                :categories="categories"
                :price-min="priceBounds.min"
                :price-max="priceBounds.max"
                :filters="filters"
                @update:filters="updateFilters"
            />

            <div class="catalog-page__content">
                <SearchBar />

                <section
                    class="catalog-results"
                    aria-labelledby="catalog-results-title"
                >
                    <h2
                        id="catalog-results-title"
                        class="catalog-results__title text-h3"
                    >
                        Каркасы и аксессуары
                    </h2>

                    <InfiniteScroll data="items">
                        <div
                            v-if="items.data.length > 0"
                            class="catalog-results__list"
                        >
                            <Card
                                v-for="module in items.data"
                                :key="module.id"
                                :module="module"
                            />
                        </div>

                        <p v-else class="catalog-results__empty">
                            Модули не найдены. Загляните позже — каталог
                            пополняется.
                        </p>
                    </InfiniteScroll>
                </section>

                <CatalogHelp />
            </div>
        </div>
    </div>
</template>

<style scoped>
.catalog-page {
    display: flex;
    width: 100%;
    flex-direction: column;
    gap: 4.8rem;
    padding-bottom: 4rem;
}

.catalog-page__layout {
    display: flex;
    align-items: flex-start;
    gap: 3.2rem;
}

.catalog-page__content {
    display: flex;
    flex: 1;
    min-width: 0;
    flex-direction: column;
    gap: 2.4rem;
}

.catalog-results {
    display: flex;
    flex-direction: column;
    gap: 2.4rem;
}

.catalog-results__title {
    color: var(--color-primary);
    font-family: "Manrope", "Arial";
    /*font-size: 2.5rem;*/
    font-weight: 500;
    line-height: 3.2rem;
}

.catalog-results__list {
    display: flex;
    flex-direction: column;
    gap: 1.6rem;
}

.catalog-results__empty {
    padding: 4.8rem 2.4rem;
    border: 1px dashed var(--color-stroke-soft);
    border-radius: 1.8rem;
    color: var(--color-second);
    font-family: "Manrope", "Arial";
    font-size: 1.6rem;
    line-height: 2.4rem;
    text-align: center;
}

@media (max-width: 980px) {
    .catalog-page__layout {
        flex-direction: column;
    }
}
</style>
