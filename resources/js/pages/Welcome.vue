<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Button from '@/shared/ui/Button.vue';

</script>

<template>
    <section class="section_welcome">
        <div class="island island-gradient-light o-hidden relative">
            <div class="welcome__island__div-left">
                <h2 class="text-h1">Экзоскелет,<br /><span class="text-h3">созданный только для Вас</span></h2>
                <div class="welcome__island__div-left_text">
                    <p>Соберите свой экзоскелет или выберите готовую сборку.</p>
                    <p>Сохраняйте прототипы и возвращайтесь к своим идеям.</p>
                </div>
                <div class="welcome__island_div-left_buttons">
                    <Button :href="'/constructor'">Собрать экзоскелет</Button>
                    <Button :href="'/catalog'" :variant="'ghost'">Смотреть каталог</Button>
                </div>
            </div>
            <div class="welcome__island__div-right">
                <div class="welcome__div-right__img imageHolder">
                    <img src="images/exoskeletons/man.png" alt="Человек в экзоскелете, его руки поднимают тяжелый груз">
                </div>
            </div>
        </div>
        <hr>
        <div class="welcome_tasks">
            <div>
                <p>1</p>
                <div>
                    <p class="text-h3">Под вашу задачу</p>
                    <p>Работа, движение, исследования</p>
                </div>
            </div>
            <div>
                <p>2</p>
                <div>
                    <p class="text-h3">Модульная система</p>
                    <p>Выбирайте нужные зоны поддержки</p>
                </div>
            </div>
            <div>
                <p>3</p>
                <div>
                    <p class="text-h3">От идеи к прототипу</p>
                    <p>Работа, движение, исследования</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section_features"></section>
</template>

<style scoped>

.section_welcome {
    display: flex;
    flex-direction: column;
    gap: 4rem;
    align-items: center;
}

hr {
    border-top: 2px solid var(--color-mid);
    width: 95%;
}

.welcome_tasks {
    display: flex;
    flex-direction: row;
    justify-content: space-between;
    width: 100%;
}

.welcome_tasks>div:nth-child(n+2) {
    border-left: 2px solid var(--color-mid);
    padding-left: 6rem;
}

.welcome_tasks>div {
    display: flex;
    gap: 2rem;
}

.welcome_tasks>div>p {
    font-weight: bold;
}

.welcome__island__div-left {
    line-height: 0.75;
    height: 100%;
    padding-left: 5rem;
    display: flex;

    flex-direction: column;
    justify-content: center;
    gap: 30px;
}

.welcome__div-right__img {
    width: 100%;
    overflow: hidden;
    border-radius: 24px;
}

.welcome__island__div-left_text {
    display: flex;
    flex-direction: column;
    gap: 1rem;
    color: var(--color-second)
}

.welcome__island_div-left_buttons {
    display: flex;
    gap: 1rem;
}
</style>
