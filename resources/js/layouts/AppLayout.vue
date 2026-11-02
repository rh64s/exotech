<script setup lang="ts">

import { defineStore } from 'pinia';



</script>

<template>
    <header>
        <div class="header_div">
            <h1>Экзоскелет</h1>
            <nav>
                <a>Главная</a>
                <a>Каталог</a>
                <a>Конструктор</a>
            </nav>
        </div>
    </header>
    <main>
        <slot />
    </main>
    <footer>
    </footer>
</template>

<style lang="css"></style>
