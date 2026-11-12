<script setup lang="ts">
import { Head } from '@inertiajs/vue3';
import Button from '@/shared/ui/Button.vue';

</script>

<template>
    <section class="section_welcome">
        <div class="island island-gradient-light o-hidden relative">
            <div class="welcome__island__div-left">
                <h2 class="text-h1">Экзоскелет,<br /><span class="text-h3">созданный только для Вас</span></h2>
                <Button :href="'/constructor'">в конструктор</Button>
            </div>
            <div class="welcome__island__div-right">
                <div class="welcome__div-right__img imageHolder">
                    <img src="images/exoskeletons/man.png" alt="Человек в экзоскелете, его руки поднимают тяжелый груз">
                </div>
            </div>
        </div>
        <div class="welcome_tasks">
            <div class="welcome_tasks__1">
                <p>1</p>
                <div>
                    <p>Под вашу задачу</p>
                    <p>Работа, движение, исследования</p>
                </div>
            </div>
            <div class="welcome_tasks__2">
                <p>2</p>
                <div>
                    <p>Модульная система</p>
                    <p>Выбирайте нужные зоны поддержки</p>
                </div>
            </div>
            <div class="welcome_tasks__3">
                <p>3</p>
                <div>
                    <p>От идеи к прототипу</p>
                    <p>Работа, движение, исследования</p>
                </div>
            </div>
        </div>
    </section>
    <section class="section_features"></section>
</template>

<style scoped>

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
</style>
