<script setup lang="ts">
import { Head, Link, useForm } from "@inertiajs/vue3";
import { catalog } from "@/routes";
import { index, install, remove } from "@/routes/schemes";

const props = defineProps<{
    scheme: { id: number; name: string };
    frameName: string;
    totalWeight: number;
    weightLimit: number;
    slots: {
        id: number;
        zone: string;
        interface: string;
        quantity: number;
        body_zone_id: number;
        attachment_interface_id: number;
        installed: { id: number; name: string }[];
        options: { id: number; name: string; weight_g: number }[];
    }[];
}>();

const form = useForm({ frame_slot_id: 0, module_id: 0 });
function attach(slot: number, module: number) {
    form.frame_slot_id = slot;
    form.module_id = module;
    form.submit(install(props.scheme.id), { preserveScroll: true });
}
</script>

<template>
    <main class="mx-auto grid max-w-4xl gap-6 p-6">
        <Head :title="scheme.name" />
        <Link :href="index()" class="underline">← Мои схемы</Link>
        <h1>Конфигуратор: {{ frameName }}</h1>
        <p>Масса сборки: {{ totalWeight }} из {{ weightLimit }} г</p>
        <p v-if="form.hasErrors" role="alert">
            {{ form.errors.frame_slot_id || form.errors.module_id }}
        </p>
        <p v-if="!slots.length">У этого каркаса нет креплений.</p>
        <section
            v-for="slot in slots"
            :key="slot.id"
            class="grid gap-3 rounded-xl border p-4"
        >
            <h2>{{ slot.zone }} · {{ slot.interface }}</h2>
            <p>Занято: {{ slot.installed.length }} из {{ slot.quantity }}</p>
            <div
                v-for="item in slot.installed"
                :key="item.id"
                class="flex justify-between"
            >
                {{ item.name }}
                <Link
                    :href="remove([scheme.id, item.id])"
                    as="button"
                    preserve-scroll
                    class="underline"
                    >Снять</Link
                >
            </div>
            <p v-if="!slot.options.length">
                Для этого крепления нет сохранённых аксессуаров.
            </p>
            <Link
                class="underline"
                :href="
                    catalog({
                        query: {
                            body_zones: [slot.body_zone_id],
                            interface: slot.attachment_interface_id,
                        },
                    })
                "
                >Найти в каталоге</Link
            >
            <button
                v-for="item in slot.options"
                :key="item.id"
                type="button"
                class="text-left underline disabled:opacity-50"
                :disabled="
                    form.processing ||
                    slot.installed.length >= slot.quantity ||
                    totalWeight + item.weight_g > weightLimit
                "
                @click="attach(slot.id, item.id)"
            >
                Добавить: {{ item.name }} ({{ item.weight_g }} г)
            </button>
        </section>
    </main>
</template>
