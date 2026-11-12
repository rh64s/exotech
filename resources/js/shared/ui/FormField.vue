<script setup lang="ts">
import { computed } from 'vue';

const model = defineModel<string>({ default: '' });

const props = withDefaults(
    defineProps<{
        /** Подпись поля. */
        label: string;
        /** Уникальный id поля (нужен для label и ошибок). */
        id: string;
        type?: string;
        /** Текст ошибки валидации. */
        error?: string;
        autocomplete?: string;
        placeholder?: string;
        required?: boolean;
        autofocus?: boolean;
    }>(),
    {
        type: 'text',
        required: false,
        autofocus: false,
    },
);

const errorId = computed(() => `${props.id}-error`);
</script>

<template>
    <div class="form-field">
        <label :for="id" class="form-field__label">
            {{ label }}
            <span v-if="required" class="form-field__required">*</span>
        </label>
        <input
            :id="id"
            v-model="model"
            :type="type"
            :autocomplete="autocomplete"
            :placeholder="placeholder"
            :required="required"
            :autofocus="autofocus"
            :aria-invalid="error ? 'true' : undefined"
            :aria-describedby="error ? errorId : undefined"
            class="form-field__input"
            :class="{ 'form-field__input_error': error }"
        />
        <p v-if="error" :id="errorId" class="form-field__error">{{ error }}</p>
    </div>
</template>

<style scoped>
.form-field {
    display: flex;
    flex-direction: column;
    gap: 6px;
    width: 100%;
}

.form-field__label {
    font-family: 'Manrope', 'Arial';
    font-size: var(--text-p);
    font-weight: 600;
    color: var(--color-second);
}

.form-field__required {
    color: var(--color-error);
}

.form-field__input {
    width: 100%;
    padding: 12px 16px;
    border: 1px solid var(--color-mid);
    border-radius: 12px;
    background-color: var(--color-surface);
    color: var(--color-primary);
    font-size: var(--text-p);
    outline: none;
    transition:
        border-color 0.2s ease,
        box-shadow 0.2s ease;
}

.form-field__input::placeholder {
    color: var(--color-second);
    opacity: 0.8;
}

.form-field__input:focus {
    border-color: var(--color-accent);
    box-shadow: 0 0 0 3px rgb(44 83 100 / 20%);
}

.form-field__input_error {
    border-color: var(--color-error);
}

.form-field__error {
    font-size: 1.3rem;
    color: var(--color-error);
}
</style>
