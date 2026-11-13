<script setup lang="ts">
import { Link } from '@inertiajs/vue3';
import { computed } from 'vue';

type ButtonVariant = 'primary' | 'secondary' | 'ghost';

const props = withDefaults(
    defineProps<{
        /** Куда ведёт кнопка. Если задан — рендерится ссылка вместо кнопки. */
        href?: string;
        /** Внешняя ссылка (http, mailto, tel) — рендерится обычный <a>, без Inertia. */
        external?: boolean;
        variant?: ButtonVariant;
        type?: 'button' | 'submit' | 'reset';
        disabled?: boolean;
        /** Компактные отступы — для шапки и плотных меню. */
        lowPadding?: boolean;
    }>(),
    {
        variant: 'primary',
        type: 'button',
        lowPadding: false,
        disabled: false,
    },
);

/** Ссылка на внешний ресурс: Inertia-переход тут не нужен. */
const isExternalLink = computed(
    () =>
        props.external || /^(https?:\/\/|mailto:|tel:)/.test(props.href ?? ''),
);

/** Кнопка без href, обычная ссылка на внешний ресурс или Inertia-переход. */
const tag = computed(() => {
    if (!props.href) {
        return 'button';
    }

    return isExternalLink.value ? 'a' : Link;
});
</script>

<template>
    <component
        :is="tag"
        :href="href"
        :type="href ? undefined : type"
        :disabled="href ? undefined : disabled"
        :aria-disabled="href && disabled ? 'true' : undefined"
        :tabindex="href && disabled ? -1 : undefined"
        :class="[
            'btn',
            `btn-${variant}`,
            { 'is-disabled': disabled },
            { 'low-padding': lowPadding },
        ]"
    >
        <slot></slot>
    </component>
</template>
