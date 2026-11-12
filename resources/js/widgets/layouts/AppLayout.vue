<script setup lang="ts">
import { Header } from '@/widgets/layouts';
import Footer from './Footer.vue';
</script>

<template>
    <Header />
    <main>
        <slot></slot>
    </main>
    <Footer />
</template>
