<script setup lang="ts">
import { Head, InfiniteScroll, router } from "@inertiajs/vue3";
import { modules } from "@/routes/catalog";
import {
    Card,
    CatalogFilters,
    CatalogHelp,
    SearchBar,
    type CatalogFilterState,
    type CatalogModule,
    type CharacteristicFilterOption,
    type FilterOption,
} from "@/widgets/catalog";
import HeaderTitle from "@/widgets/HeaderTitle.vue";

type PaginatedModules = {
    data: CatalogModule[];
};

const props = defineProps<{
    items: PaginatedModules;
    types: FilterOption[];
    body_zones: FilterOption[];
    characteristic_options: CharacteristicFilterOption[];
    price_bounds: { min: number | null; max: number | null };
    filters: CatalogFilterState & {
        saved: boolean;
        interface: number | null;
        search: string;
    };
}>();

function updateFilters(
    filters: CatalogFilterState,
    saved = props.filters.saved,
    attachment = props.filters.interface,
    search = props.filters.search,
): void {
    const query = {
        ...(saved && { saved: 1 }),
        ...(attachment && { interface: attachment }),
        ...(search && { search }),
        ...(filters.body_zones?.length && {
            body_zones: filters.body_zones,
        }),
        ...(filters.types.length > 0 && { types: filters.types }),
        ...(filters.characteristic_values.length > 0 && {
            characteristic_values: filters.characteristic_values,
        }),
        ...(filters.min_price !== null && { min_price: filters.min_price }),
        ...(filters.max_price !== null && { max_price: filters.max_price }),
    };

    router.get(modules.url(), query, {
        only: ["items", "filters"],
        preserveScroll: true,
        preserveState: true,
        replace: true,
        reset: ["items"],
    });
}
</script>

<template>
    <div class="catalog-page">
        <Head title="Каталог модулей" />
        <HeaderTitle
            title="Каталог модулей"
            description="Сохраняйте модули, чтобы использовать их в своих сборках."
        />
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
                :characteristic-options="characteristic_options"
                :price-min="price_bounds.min ?? 0"
                :price-max="price_bounds.max ?? 0"
                :filters="filters"
                @update:filters="updateFilters"
            />

            <div class="catalog-page__content">
                <SearchBar
                    :search="filters.search"
                    @search="updateFilters(filters, filters.saved, filters.interface, $event)"
                />

                <section
                    class="catalog-results"
                    aria-labelledby="catalog-results-title"
                >
                    <h2
                        id="catalog-results-title"
                        class="catalog-results__title text-h3"
                    >
                        Модули
                    </h2>

                    <InfiniteScroll data="items" preserve-url>
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
                            Модули не найдены.
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
