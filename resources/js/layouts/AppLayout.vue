<script setup lang="ts">
import { defineStore } from 'pinia';
</script>

<template>
    <header>
        <div class="header_div">
            <h1 class="logo">ЭкзоТех</h1>
            <nav>
                <a class="text-p">Главная</a>
                <a class="text-p">Каталог</a>
                <a class="text-p">Конструктор</a>
            </nav>
        </div>
    </header>
    <main>
        <slot />
    </main>
    <footer>
        <div class="footer_content">
            <p>сделано с душой</p>
        </div>
    </footer>
</template>

<style scoped>
header {
    width: 100%;
    height: 42px;
    display: flex;
    justify-content: center;
    align-items: center;
}

.header_div {
    width: var(--content-width);
    height: fit-content;
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    align-items: center;
    background-color: var(--color-second);
    padding: 4px 14px;
    border-radius: 16px;
}

nav {
    width: fit-content;
    display: flex;
    flex-direction: row;
    gap: 14px;
    color: var(--color-text-light);
}
</style>
