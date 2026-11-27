<script setup lang="ts">
import { computed } from "vue";
import { Link, usePage, useForm } from "@inertiajs/vue3";
import { login } from "@/routes";
import { store as storeScheme } from "@/routes/schemes";
import { show } from "@/routes/modules";
import {
    destroy as removeFromWishlist,
    store as addToWishlist,
} from "@/routes/wishlist";
import { formatPrice, type CatalogFrame, type CatalogModule } from "./modules";
import Arrow from "@/assets/svg/Arrow.vue";
import ProductPlaceholder from "@/assets/svg/ProductPlaceholder.vue";

const props = defineProps<{
    module: CatalogModule | CatalogFrame;
}>();

const frameId = computed(() =>
    "frame_id" in props.module ? props.module.frame_id : null,
);
const bodyZone = computed(() =>
    "body_zone" in props.module ? props.module.body_zone : null,
);
const isSaved = computed(
    () => "is_in_wishlist" in props.module && props.module.is_in_wishlist === true,
);
const characteristics = computed(() =>
    "characteristics" in props.module
        ? props.module.characteristics.filter(({ value }) => value.trim())
        : [],
);

const price = computed(() => `${formatPrice(props.module.price)} ₽`);
const page = usePage<{ auth: { user: { id: number } | null } }>();

const form = useForm({});

function changeSaved(): void {
    form.submit(
        isSaved.value
            ? removeFromWishlist(props.module.id)
            : addToWishlist(props.module.id),
        { preserveScroll: true },
    );
}
</script>

<template>
    <article class="module-card">
        <div class="module-card__image">
            <template v-if="props.module.image_url">
                <img
                    :src="props.module.image_url"
                    :alt="props.module.name"
                    loading="lazy"
                />
            </template>
            <ProductPlaceholder
                v-else
                class="module-card__placeholder"
            ></ProductPlaceholder>
        </div>

        <div class="module-card__content">
            <div class="module-card__main">
                <h3 class="module-card__title text-h3">
                    <Link :href="show(module.id)">{{ module.name }}</Link>
                </h3>
                <p class="module-card__description">
                    {{ props.module.description }}
                </p>

                <div class="module-card__badges">
                    <span class="module-card__badge"
                        >Масса: {{ module.weight_g }} г</span
                    >
                    <span class="module-card__badge">
                        Тип: {{ module.module_type.name }}
                    </span>
                    <span v-if="bodyZone" class="module-card__badge">
                        Зона: {{ bodyZone.name }}
                    </span>
                    <span
                        v-for="characteristic in characteristics"
                        :key="characteristic.id"
                        class="module-card__badge"
                    >
                        {{ characteristic.name }}:
                        {{ characteristic.value.trim() }}
                        {{ characteristic.unit }}
                    </span>
                </div>
            </div>

            <div class="module-card__footer">
                <div class="module-card__divider"></div>
                <div class="module-card__price-row">
                    <p class="module-card__price">{{ price }}</p>
                    <template v-if="frameId !== null">
                        <Link
                            v-if="page.props.auth.user"
                            :href="storeScheme(frameId)"
                            as="button"
                            class="module-card__link"
                            >Создать сборку <Arrow></Arrow
                        ></Link>
                        <Link v-else :href="login()" class="module-card__link"
                            >Войти для сборки <Arrow></Arrow
                        ></Link>
                    </template>
                    <button
                        v-else-if="page.props.auth.user"
                        type="button"
                        class="btn btn-primary low-padding"
                        :disabled="form.processing"
                        :aria-pressed="isSaved"
                        @click="changeSaved"
                    >
                        {{ isSaved ? "Убрать из списка" : "Сохранить для сборки" }}
                    </button>
                    <Link v-else :href="login()" class="module-card__link">
                        Войти, чтобы сохранить
                    </Link>
                    <Link :href="show(module.id)" class="module-card__link"
                        >Подробнее</Link
                    >
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

.module-card__title {
    overflow: hidden;
    color: var(--color-primary);
    font-family: "Manrope", "Arial";
    font-weight: 500;
    line-clamp: 1;
}
.module-card__title > * {
    font-size: inherit;
}

.module-card__description {
    overflow: hidden;
    color: var(--color-second);
    font-family: "Manrope", "Arial";
    font-size: 1.4rem;
    font-weight: 400;
    line-height: 1.8rem;
    line-clamp: 1;
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
    font-family: "Manrope", "Arial";
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
    font-family: "Inter", "Segoe UI", sans-serif;
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
