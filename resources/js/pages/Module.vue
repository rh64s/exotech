<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import { catalog, login } from "@/routes";
import { store as createScheme, index as schemes } from "@/routes/schemes";
import { store, destroy } from "@/routes/wishlist";
import {
    formatPrice,
    type CatalogModule,
    type ModuleSummary,
} from "@/widgets/catalog/modules";
import Arrow from "@/assets/svg/Arrow.vue";

const props = defineProps<{
    product: CatalogModule & { attachment_interface: ModuleSummary | null };
    isSaved: boolean;
    frame: {
        id: number;
        weightLimit: number;
        slots: {
            id: number;
            zone: string;
            interface: string;
            quantity: number;
        }[];
    } | null;
}>();

const form = useForm({});

function changeSaved(): void {
    form.submit(
        props.isSaved ? destroy(props.product.id) : store(props.product.id),
        {
            preserveScroll: true,
        },
    );
}
</script>

<template>
    <div class="module-page">
        <Head :title="product.name" />

        <nav class="module-page__breadcrumb" aria-label="Навигация">
            <Link :href="catalog()">Каталог модулей</Link>
            <span aria-hidden="true">/</span>
            <span>{{
                product.module_type.category?.name ?? product.module_type.name
            }}</span>
        </nav>

        <section class="product-hero" aria-labelledby="product-title">
            <div class="product-hero__visual">
                <img
                    v-if="product.image_url"
                    class="product-hero__image"
                    :src="product.image_url"
                    :alt="product.name"
                />
                <div
                    v-else
                    class="product-hero__placeholder"
                    aria-hidden="true"
                >
                    <svg viewBox="0 0 120 120" fill="none">
                        <rect
                            x="23"
                            y="32"
                            width="74"
                            height="56"
                            rx="12"
                            stroke="currentColor"
                            stroke-width="2"
                        />
                        <path
                            d="M23 50h74M45 32v56M75 32v56"
                            stroke="currentColor"
                            stroke-width="2"
                        />
                    </svg>
                    <span>EXO / MODULE</span>
                </div>
                <span class="product-hero__visual-label"
                    >Модуль {{ product.module_type.name }}</span
                >
            </div>

            <div class="product-hero__details">
                <p class="product-hero__eyebrow">
                    {{
                        product.module_type.category?.name ?? "Каталог модулей"
                    }}
                </p>
                <h1 id="product-title" class="product-hero__title">
                    {{ product.name }}
                </h1>
                <p class="product-hero__type">{{ product.module_type.name }}</p>
                <p v-if="product.description" class="product-hero__description">
                    {{ product.description }}
                </p>

                <div class="product-facts" aria-label="Основные характеристики">
                    <div class="product-facts__item">
                        <span class="product-facts__label">Масса</span>
                        <span class="product-facts__value"
                            >{{ product.weight_g }} г</span
                        >
                    </div>
                    <div class="product-facts__item">
                        <span class="product-facts__label">Зона</span>
                        <span class="product-facts__value">
                            {{ product.body_zone?.name ?? "Универсальная" }}
                        </span>
                    </div>
                    <div class="product-facts__item">
                        <span class="product-facts__label">Интерфейс</span>
                        <span class="product-facts__value">
                            {{
                                product.attachment_interface?.name ??
                                "Не указан"
                            }}
                        </span>
                    </div>
                </div>

                <div class="product-hero__purchase">
                    <p class="product-hero__price">
                        {{ formatPrice(product.price) }} <span>₽</span>
                    </p>
                    <template v-if="$page.props.auth.user">
                        <button
                            type="button"
                            class="product-button product-button--secondary"
                            :disabled="form.processing"
                            :aria-pressed="isSaved"
                            @click="changeSaved"
                        >
                            {{
                                isSaved
                                    ? "Убрать из сохранённых"
                                    : "♡ Сохранить"
                            }}
                        </button>
                        <Link
                            v-if="frame"
                            :href="createScheme(frame.id)"
                            as="button"
                            class="product-button product-button--primary"
                        >
                            Создать сборку <span aria-hidden="true">→</span>
                        </Link>
                    </template>
                    <Link
                        v-else
                        :href="login()"
                        class="product-button product-button--primary"
                    >
                        Войти, чтобы начать
                        <span aria-hidden="true"><Arrow></Arrow></span>
                    </Link>
                </div>
                <p
                    v-if="$page.props.errors.scheme_limit"
                    class="product-page__error"
                    role="alert"
                >
                    {{ $page.props.errors.scheme_limit }}
                </p>
            </div>
        </section>

        <section v-if="frame" class="info-panel" aria-labelledby="frame-title">
            <div class="info-panel__heading">
                <div>
                    <p class="section-eyebrow">Совместимость</p>
                    <h2 id="frame-title" class="section-title">
                        Крепления каркаса
                    </h2>
                </div>
                <p class="info-panel__limit">
                    Лимит сборки <strong>{{ frame.weightLimit }} г</strong>
                </p>
            </div>

            <ul v-if="frame.slots.length" class="mount-list">
                <li
                    v-for="slot in frame.slots"
                    :key="slot.id"
                    class="mount-list__item"
                >
                    <span class="mount-list__marker" aria-hidden="true">+</span>
                    <span class="mount-list__name">{{ slot.zone }}</span>
                    <span class="mount-list__interface">{{
                        slot.interface
                    }}</span>
                    <span class="mount-list__quantity"
                        >Мест: {{ slot.quantity }}</span
                    >
                </li>
            </ul>
            <p v-else class="info-panel__empty">
                У каркаса пока нет креплений для аксессуаров.
            </p>
        </section>

        <section
            v-if="
                product.characteristics.length ||
                product.compatible_modules.length
            "
            class="product-sections"
            aria-label="Дополнительная информация"
        >
            <section v-if="product.characteristics.length" class="info-panel">
                <p class="section-eyebrow">Параметры</p>
                <h2 class="section-title">Характеристики</h2>
                <dl class="spec-list">
                    <div
                        v-for="item in product.characteristics"
                        :key="item.id"
                        class="spec-list__item"
                    >
                        <dt>{{ item.name }}</dt>
                        <dd>
                            {{ item.value
                            }}<span v-if="item.unit"> {{ item.unit }}</span>
                        </dd>
                    </div>
                </dl>
            </section>

            <section
                v-if="product.compatible_modules.length"
                class="info-panel"
            >
                <p class="section-eyebrow">Экосистема EXO</p>
                <h2 class="section-title">Совместимые модули</h2>
                <ul class="compatible-list">
                    <li
                        v-for="module in product.compatible_modules"
                        :key="module.id"
                    >
                        {{ module.name }}
                    </li>
                </ul>
            </section>
        </section>

        <section class="module-page__footer">
            <p>Подберите модули под свои задачи и соберите свой экзоскелет.</p>
            <Link :href="catalog()"
                >Вернуться в каталог
                <span aria-hidden="true"><Arrow></Arrow></span
            ></Link>
            <Link v-if="$page.props.auth.user" :href="schemes()"
                >Мои схемы</Link
            >
        </section>
    </div>
</template>

<style scoped>
.module-page {
    display: grid;
    width: var(--content-width);
    gap: 2.4rem;
    padding: 2.4rem 0 6.4rem;
}

.module-page__breadcrumb {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1rem;
    color: var(--color-second);
    font-size: 1.3rem;
    line-height: 2rem;
}

.module-page__breadcrumb a,
.module-page__footer a {
    color: var(--color-accent);
    text-decoration: none;
    transition: color 0.2s ease;
    font-size: var(--text-p);
}

.module-page__breadcrumb a:hover,
.module-page__footer a:hover {
    color: var(--color-hover);
}

.product-hero {
    display: grid;
    grid-template-columns: minmax(0, 0.95fr) minmax(0, 1.05fr);
    gap: 4.8rem;
    padding: 3.2rem;
    border: 1px solid var(--color-disabled);
    border-radius: 2.4rem;
    background: var(--gradient-primary);
}

.product-hero__visual {
    position: relative;
    display: grid;
    min-height: 42rem;
    overflow: hidden;
    place-items: center;
    border-radius: 1.8rem;
    background: var(--color-image-placeholder);
}

.product-hero__image {
    display: block;
    width: 100%;
    height: 100%;
    min-height: 42rem;
    object-fit: cover;
}

.product-hero__placeholder {
    display: grid;
    justify-items: center;
    gap: 1.6rem;
    color: var(--color-stroke-soft);
}

.product-hero__placeholder svg {
    width: 12rem;
    height: 12rem;
}

.product-hero__placeholder span,
.product-hero__visual-label,
.product-hero__eyebrow,
.section-eyebrow {
    font-size: 1.2rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.8rem;
    text-transform: uppercase;
}

.product-hero__visual-label {
    position: absolute;
    right: 1.6rem;
    bottom: 1.6rem;
    padding: 0.8rem 1.2rem;
    border: 1px solid rgb(255 255 255 / 60%);
    border-radius: 2rem;
    background: rgb(255 255 255 / 82%);
    color: var(--color-accent);
    letter-spacing: 0.04em;
    text-transform: none;
}

.product-hero__details {
    display: flex;
    min-width: 0;
    flex-direction: column;
    align-items: flex-start;
    justify-content: center;
    gap: 1.6rem;
    padding: 1.6rem 0;
}

.product-hero__eyebrow,
.section-eyebrow {
    color: var(--color-accent);
}

.product-hero__title {
    color: var(--color-primary);
    font-family: "Manrope", "Arial", sans-serif;
    font-size: clamp(3.2rem, 4vw, 4.8rem);
    font-weight: 500;
    line-height: 1.12;
    overflow-wrap: anywhere;
}

.product-hero__type {
    color: var(--color-second);
    font-family: "Manrope", "Arial", sans-serif;
    font-size: 1.8rem;
    line-height: 2.7rem;
}

.product-hero__description {
    max-width: 58rem;
    color: var(--color-second);
    font-size: 1.6rem;
    line-height: 1.7;
}

.product-facts {
    display: grid;
    width: 100%;
    grid-template-columns: repeat(3, minmax(0, 1fr));
    gap: 1.2rem;
    margin-top: 0.8rem;
}

.product-facts__item {
    display: grid;
    align-content: start;
    gap: 0.8rem;
    padding: 1.4rem;
    border: 1px solid var(--color-disabled);
    border-radius: 1.2rem;
    background: var(--color-base);
}

.product-facts__label {
    color: var(--color-second);
    font-size: 1.2rem;
    line-height: 1.6rem;
}

.product-facts__value {
    color: var(--color-primary);
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 1.9rem;
    overflow-wrap: anywhere;
}

.product-hero__purchase {
    display: flex;
    width: 100%;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.2rem;
    margin-top: 0.8rem;
}

.product-hero__price {
    margin-right: auto;
    color: var(--color-primary);
    font-family: "Manrope", "Arial", sans-serif;
    font-size: 3.2rem;
    font-weight: 600;
    line-height: 4rem;
}

.product-hero__price span {
    color: var(--color-second);
    font-size: 2rem;
    font-weight: 500;
}

.product-button {
    display: inline-flex;
    min-height: 4.8rem;
    align-items: center;
    justify-content: center;
    gap: 0.8rem;
    padding: 0 1.8rem;
    border: 1px solid transparent;
    border-radius: 1.2rem;
    font-family: "Manrope", "Arial", sans-serif;
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 2rem;
    text-align: center;
    text-decoration: none;
    cursor: pointer;
    transition:
        background-color 0.2s ease,
        border-color 0.2s ease,
        color 0.2s ease,
        transform 0.2s ease;
}

.product-button:hover {
    transform: translateY(-1px);
}

.product-button:focus-visible,
.module-page__breadcrumb a:focus-visible,
.module-page__footer a:focus-visible {
    outline: 2px solid var(--color-accent);
    outline-offset: 3px;
}

.product-button:disabled {
    cursor: wait;
    opacity: 0.65;
}

.product-button--primary {
    background: var(--color-accent);
    color: var(--color-text-light);
}

.product-button--primary:hover {
    background: var(--color-hover);
}

.product-button--secondary {
    border-color: var(--color-stroke-soft);
    background: var(--color-base);
    color: var(--color-accent);
}

.product-button--secondary:hover {
    border-color: var(--color-accent);
    background: var(--color-mid);
}

.product-page__error {
    color: var(--color-error);
    font-size: 1.4rem;
    line-height: 2rem;
}

.info-panel {
    padding: 2.4rem;
    border: 1px solid var(--color-disabled);
    border-radius: 1.8rem;
    background: var(--color-surface);
}

.info-panel__heading {
    display: flex;
    flex-wrap: wrap;
    align-items: flex-end;
    justify-content: space-between;
    gap: 1.6rem;
    margin-bottom: 2rem;
}

.section-title {
    margin-top: 0.6rem;
    color: var(--color-primary);
    font-family: "Manrope", "Arial", sans-serif;
    font-size: 2.8rem;
    font-weight: 500;
    line-height: 1.25;
}

.info-panel__limit {
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 2rem;
}

.info-panel__limit strong {
    margin-left: 0.4rem;
    color: var(--color-primary);
    font-size: inherit;
}

.mount-list,
.compatible-list {
    display: grid;
    gap: 0.8rem;
    list-style: none;
}

.mount-list__item {
    display: grid;
    grid-template-columns: auto minmax(10rem, 1fr) minmax(10rem, 1fr) auto;
    align-items: center;
    gap: 1.2rem;
    padding: 1.4rem;
    border: 1px solid var(--color-disabled);
    border-radius: 1.2rem;
    background: var(--color-base);
}

.mount-list__marker {
    display: grid;
    width: 2.8rem;
    height: 2.8rem;
    place-items: center;
    border-radius: 50%;
    background: var(--color-chip);
    color: var(--color-accent);
    font-size: 1.8rem;
    line-height: 1;
}

.mount-list__name,
.spec-list dd,
.compatible-list li {
    color: var(--color-primary);
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 2rem;
}

.mount-list__interface,
.mount-list__quantity {
    color: var(--color-second);
    font-size: 1.3rem;
    line-height: 1.8rem;
}

.info-panel__empty {
    color: var(--color-second);
    font-size: 1.5rem;
    line-height: 2.2rem;
}

.product-sections {
    display: grid;
    grid-template-columns: repeat(2, minmax(0, 1fr));
    gap: 2.4rem;
}

.spec-list {
    display: grid;
    margin-top: 1.6rem;
}

.spec-list__item {
    display: flex;
    justify-content: space-between;
    gap: 2rem;
    padding: 1.2rem 0;
    border-bottom: 1px solid var(--color-disabled);
}

.spec-list__item:last-child {
    border-bottom: 0;
}

.spec-list dt {
    color: var(--color-second);
    font-size: 1.4rem;
    line-height: 2rem;
}

.spec-list dd {
    text-align: right;
}

.compatible-list {
    margin-top: 1.6rem;
}

.compatible-list li {
    padding: 1.2rem 1.4rem;
    border-radius: 1rem;
    background: var(--color-base);
}

.module-page__footer {
    display: flex;
    flex-wrap: wrap;
    align-items: center;
    gap: 1.6rem 2.4rem;
    padding: 20px;
    border-radius: 1.8rem;
    background: var(--color-mid);
}

.module-page__footer p {
    flex: 1 1 32rem;
    color: var(--color-primary);
    font-family: "Manrope", "Arial", sans-serif;
    font-size: 1.8rem;
    line-height: 1.5;
}

.module-page__footer a {
    font-size: 1.4rem;
    font-weight: 600;
    line-height: 2rem;
}

@media (max-width: 900px) {
    .product-hero {
        grid-template-columns: minmax(0, 1fr);
        gap: 2.4rem;
    }

    .product-hero__visual,
    .product-hero__image {
        min-height: 32rem;
    }
}

@media (max-width: 700px) {
    .module-page {
        width: 95vw;
        gap: 1.6rem;
        padding-top: 1.6rem;
    }

    .product-hero {
        gap: 1.6rem;
        padding: 1.6rem;
        border-radius: 1.8rem;
    }

    .product-hero__visual,
    .product-hero__image {
        min-height: 24rem;
    }

    .product-hero__details {
        gap: 1.2rem;
        padding: 0.8rem 0;
    }

    .product-facts {
        grid-template-columns: 1fr;
        gap: 0.8rem;
    }

    .product-facts__item {
        grid-template-columns: minmax(8rem, 0.6fr) 1fr;
        align-items: center;
    }

    .product-hero__purchase {
        align-items: stretch;
    }

    .product-hero__price {
        width: 100%;
    }

    .product-button {
        flex: 1 1 auto;
    }

    .info-panel {
        padding: 1.8rem;
    }

    .product-sections {
        grid-template-columns: 1fr;
        gap: 1.6rem;
    }

    .mount-list__item {
        grid-template-columns: auto minmax(0, 1fr);
    }

    .mount-list__interface,
    .mount-list__quantity {
        grid-column: 2;
    }

    .module-page__footer {
        align-items: flex-start;
        flex-direction: column;
        padding: 1.8rem;
    }
}
</style>
