<script setup lang="ts">
import { Head, InfiniteScroll, Link, router } from "@inertiajs/vue3";
import { frames } from "@/routes/catalog";
import { index as schemes } from "@/routes/schemes";
import HeaderTitle from "@/widgets/HeaderTitle.vue";
import {
    Card,
    CatalogFilters,
    SearchBar,
    type CatalogFilterState,
    type CatalogFrame,
    type CharacteristicFilterOption,
    type FilterOption,
} from "@/widgets/catalog";

const props = defineProps<{
    items: { data: CatalogFrame[] };
    types: FilterOption[];
    characteristic_options: CharacteristicFilterOption[];
    price_bounds: { min: number | null; max: number | null };
    filters: CatalogFilterState & { search: string };
}>();

function updateFilters(filters: CatalogFilterState, search = props.filters.search): void {
    const query = {
        ...(search && { search }),
        ...(filters.types.length && { types: filters.types }),
        ...(filters.characteristic_values.length > 0 && {
            characteristic_values: filters.characteristic_values,
        }),
        min_price: filters.min_price ?? undefined,
        max_price: filters.max_price ?? undefined,
        max_weight_g: filters.max_weight_g ?? undefined,
        min_total_weight_g: filters.min_total_weight_g ?? undefined,
    };

    router.get(frames.url(), query, {
        only: ["items", "filters"],
        reset: ["items"],
        preserveState: true,
        preserveScroll: true,
        replace: true,
    });
}
</script>

<template>
    <div class="frames-page">
        <Head title="Каталог каркасов" />
        <HeaderTitle
            title="Каталог каркасов"
            description="Выберите каркас, чтобы начать новую сборку экзоскелета."
        />
        <p v-if="$page.props.errors.scheme_limit" role="alert">
            {{ $page.props.errors.scheme_limit }}
            <Link :href="schemes()" class="underline">Мои схемы</Link>
        </p>

        <div class="frames-page__layout">
            <CatalogFilters
                :types="types"
                :characteristic-options="characteristic_options"
                :price-min="price_bounds.min ?? 0"
                :price-max="price_bounds.max ?? 0"
                :filters="filters"
                frame-limits
                @update:filters="updateFilters"
            />
            <div class="frames-page__list">
                <SearchBar
                    :search="filters.search"
                    label="Поиск по названию каркаса"
                    placeholder="Найти каркас по названию"
                    @search="updateFilters(filters, $event)"
                />
                <InfiniteScroll data="items" preserve-url>
                    <div v-if="items.data.length" class="frames-page__list">
                        <Card
                            v-for="frame in items.data"
                            :key="frame.id"
                            :module="frame"
                        />
                    </div>
                    <p v-else>
                        {{ price_bounds.min === null
                            ? "В каталоге пока нет каркасов."
                            : "По заданным фильтрам каркасов не найдено." }}
                    </p>
                </InfiniteScroll>
            </div>
        </div>
    </div>
</template>

<style scoped>
.frames-page,
.frames-page__list {
    display: flex;
    flex-direction: column;
    gap: 1.6rem;
}

.frames-page {
    width: 100%;
    gap: 2.4rem;
    padding-bottom: 4rem;
}

.frames-page__layout {
    display: flex;
    align-items: flex-start;
    gap: 3.2rem;
}

.frames-page__list {
    flex: 1;
    min-width: 0;
    width: 100%;
}

@media (max-width: 980px) {
    .frames-page__layout {
        flex-direction: column;
    }
}
</style>
