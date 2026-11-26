<script setup lang="ts">
import { Head, Link, router } from '@inertiajs/vue3';
import { catalog } from '@/routes';
import { destroy, show } from '@/routes/schemes';

defineProps<{ schemes: { id: number; name: string; installations_count: number }[]; limit: number }>();

function deleteScheme(id: number) {
    if (window.confirm('Удалить эту сборку со всеми установленными аксессуарами?')) {
        router.delete(destroy.url(id));
    }
}
</script>

<template>
    <main class="mx-auto grid max-w-4xl gap-6 p-6">
        <Head title="Мои схемы" />
        <h1>Мои схемы</h1>
        <p>Использовано: {{ schemes.length }} из {{ limit }}</p>
        <Link v-if="schemes.length < limit" :href="catalog()" class="underline">Выбрать каркас для новой сборки</Link>
        <p v-else>Чтобы начать новую сборку, удалите одну из существующих.</p>
        <section v-for="scheme in schemes" :key="scheme.id" class="grid gap-3 rounded-xl border p-4">
            <h2>{{ scheme.name }} · № {{ scheme.id }}</h2>
            <p>Установлено аксессуаров: {{ scheme.installations_count }}</p>
            <Link :href="show(scheme.id)" class="underline">Продолжить сборку</Link>
            <button type="button" class="text-left underline" @click="deleteScheme(scheme.id)">Удалить сборку</button>
        </section>
    </main>
</template>
