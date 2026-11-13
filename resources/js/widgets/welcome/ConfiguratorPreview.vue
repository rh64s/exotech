<script setup lang="ts">
const buildParts = [
    { index: '01', label: 'Основа', value: 'Нижняя часть тела' },
    { index: '02', label: 'Тип поддержки', value: 'Активная' },
    { index: '03', label: 'Модули', value: 'Выбрать модули +' },
];
</script>

<template>
    <div class="configurator-preview">
        <h3 class="configurator-preview__title">Новая сборка</h3>

        <div class="configurator-preview__divider"></div>

        <div class="configurator-preview__body">
            <div class="configurator-preview__image">
                <img
                    src="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg'/%3E"
                    alt="Превью модульной сборки экзоскелета"
                />
            </div>

            <div class="configurator-preview__parts">
                <p class="configurator-preview__label">Состав сборки</p>

                <div
                    v-for="part in buildParts"
                    :key="part.index"
                    class="configurator-preview__part"
                >
                    <span class="configurator-preview__part-index">
                        {{ part.index }}
                    </span>
                    <span class="configurator-preview__part-text">
                        <span class="configurator-preview__part-label">
                            {{ part.label }}
                        </span>
                        <span class="configurator-preview__part-value">
                            {{ part.value }}
                        </span>
                    </span>
                </div>
            </div>
        </div>

        <div class="configurator-preview__divider"></div>

        <p class="configurator-preview__note">
            Сохраните сборку и вернитесь к ней позже
        </p>
    </div>
</template>

<style scoped>
.configurator-preview {
    display: flex;
    flex-direction: column;
    width: 100%;
    max-width: 594px;
    padding: 22px 24px 23px;
    border: 1px solid var(--color-disabled);
    border-radius: 18px;
    background-color: #ffffff;
    box-shadow: var(--shadow);
}

.configurator-preview__title {
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: 1.8rem;
    font-weight: 600;
    line-height: 2.3rem;
}

.configurator-preview__divider {
    height: 1px;
    margin: 16px 0;
    background-color: var(--color-disabled);
}

.configurator-preview__body {
    display: grid;
    grid-template-columns: 292px minmax(0, 1fr);
    gap: 24px;
}

.configurator-preview__image {
    height: 285px;
    overflow: hidden;
    border-radius: 18px;
    background-color: var(--color-image-placeholder);
}

.configurator-preview__image img {
    display: block;
    width: 100%;
    height: 100%;
    object-fit: cover;
}

.configurator-preview__parts {
    display: flex;
    flex-direction: column;
    gap: 15px;
}

.configurator-preview__label {
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    letter-spacing: 0.08em;
    line-height: 1.4rem;
    text-transform: uppercase;
}

.configurator-preview__part {
    display: flex;
    gap: 14px;
    padding: 14px;
    border-radius: 10px;
    background-color: var(--color-surface);
}

.configurator-preview__part-index {
    color: var(--color-second);
    font-size: 1.1rem;
    font-weight: 600;
    line-height: 1.4rem;
}

.configurator-preview__part-text {
    display: flex;
    flex-direction: column;
    gap: 3px;
}

.configurator-preview__part-label {
    color: var(--color-second);
    font-size: 1.2rem;
    line-height: 1.6rem;
}

.configurator-preview__part-value {
    color: var(--color-primary);
    font-size: 1.3rem;
    font-weight: 500;
    line-height: 1.7rem;
}

.configurator-preview__note {
    color: var(--color-second);
    font-size: 1.2rem;
    line-height: 1.6rem;
}
</style>
