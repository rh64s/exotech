<script setup lang="ts">

const props = defineProps<{
    chats: {
        id: number;
        name: string;
        last_message: {
            message: string;
            author: string;
        }
        need_to_read: boolean;
    }
}>();

</script>

<template>

</template>

<style scoped>

</style>
