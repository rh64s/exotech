<script setup lang="ts">
import { Link, usePage } from '@inertiajs/vue3';
import { computed, onBeforeUnmount, onMounted, ref, watch } from 'vue';
import { home, login, register } from '@/routes';
import { Button } from '@/shared/ui';

const page = usePage();
const isOpen = ref(false);

const isGuest = computed(() => !page.props.auth.user);

const navLinks = [
    { label: 'Главная', href: '/' },
    { label: 'Каталог', href: '/catalog' },
    { label: 'Конструктор', href: '/constructor' },
];

function toggle(): void {
    isOpen.value = !isOpen.value;
}

function close(): void {
    isOpen.value = false;
}

function onKeydown(event: KeyboardEvent): void {
    if (event.key === 'Escape') {
        close();
    }
}

watch(isOpen, (open) => {
    document.body.style.overflow = open ? 'hidden' : '';
});

onMounted(() => {
    window.addEventListener('keydown', onKeydown);
});

onBeforeUnmount(() => {
    window.removeEventListener('keydown', onKeydown);
    document.body.style.overflow = '';
});
</script>

<template>
    <header>
        <div class="header_div">
            <Link :href="home.url()" class="logo text-p">ЭкзоТех</Link>

            <nav class="header__auth" aria-label="Авторизация">
                <Button :href="login.url()" variant="ghost" low-padding>
                    Каталог
                </Button>
                <Button :href="login.url()" variant="ghost" low-padding>
                    Конструктор
                </Button>
                <Button :href="login.url()" variant="ghost" low-padding>
                    Главная
                </Button>
                <template v-if="isGuest">
                    <Button :href="register.url()" variant="ghost" low-padding>
                        Регистрация
                    </Button>
                    <Button :href="login.url()" variant="ghost" low-padding>
                        Войти
                    </Button>
                </template>
            </nav>


            <!-- <button
                type="button"
                class="header__burger"
                :class="{ 'header__burger_open': isOpen }"
                :aria-expanded="isOpen"
                aria-controls="main-menu"
                :aria-label="isOpen ? 'Закрыть меню' : 'Открыть меню'"
                @click="toggle"
            >
                <span></span>
                <span></span>
                <span></span>
            </button> -->

            <!-- <Transition name="menu">
                <nav
                    v-if="isOpen"
                    id="main-menu"
                    class="header__menu"
                    aria-label="Основное меню"
                >
                    <Link
                        v-for="link in navLinks"
                        :key="link.href"
                        :href="link.href"
                        class="header__menu-link"
                        @click="close"
                    >
                        {{ link.label }}
                    </Link>
                </nav>
            </Transition> -->
        </div>
    </header>
</template>

<style scoped>
header {
    width: 100%;
    display: flex;
    margin-top: 8px;
    justify-content: center;
    align-items: center;
    position: relative;
    z-index: 50;
    color: var(--color-primary);
}

.header_div {
    position: relative;
    width: var(--content-width);
    display: flex;
    justify-content: space-between;
    align-items: center;
    gap: 16px;
    background-color: var(--color-mid);
    padding: 16px;
    border-radius: 16px;
}

.header__auth {
    display: flex;
    align-items: center;
    gap: 8px;
}

.logo {
    font-weight: 700;
    text-decoration: none;
}

.header__burger {
    justify-self: end;
    display: flex;
    flex-direction: column;
    justify-content: center;
    gap: 5px;
    width: 44px;
    height: 44px;
    padding: 10px;
    border: none;
    border-radius: 12px;
    cursor: pointer;
    transition: background-color 0.2s ease;
}

.header__burger:hover {
    background-color: var(--color-accent);
}

.header__burger:hover span {
    background-color: var(--color-text-light);
}

.header__burger span {
    display: block;
    width: 100%;
    height: 2px;
    border-radius: 2px;
    background-color: var(--color-primary);
    transition:
        transform 0.2s ease,
        opacity 0.2s ease;
}

.header__burger_open span:nth-child(1) {
    transform: translateY(7px) rotate(45deg);
}

.header__burger_open span:nth-child(2) {
    opacity: 0;
}

.header__burger_open span:nth-child(3) {
    transform: translateY(-7px) rotate(-45deg);
}

.header__menu {
    position: absolute;
    top: calc(100% + 8px);
    right: 0;
    display: flex;
    flex-direction: column;
    gap: 4px;
    width: 280px;
    padding: 12px;
    border-radius: 16px;
    background-color: var(--color-surface);
    box-shadow: 0 16px 40px rgb(15 32 39 / 15%);
    z-index: 60;
}

.header__menu-link {
    padding: 14px 16px;
    border-radius: 10px;
    color: var(--color-primary);
    font-family: 'Manrope', 'Arial';
    font-size: var(--text-p);
    font-weight: 600;
    text-decoration: none;
    transition:
        background-color 0.2s ease,
        color 0.2s ease;
}

.header__menu-link:hover {
    background-color: var(--color-mid);
    color: var(--color-accent);
}

.menu-enter-active,
.menu-leave-active {
    transition:
        opacity 0.15s ease,
        transform 0.15s ease;
}

.menu-enter-from,
.menu-leave-to {
    opacity: 0;
    transform: translateY(-8px);
}

@media (max-width: 600px) {
    .header_div {
        grid-template-columns: 1fr auto;
    }

    .logo {
        display: none;
    }

    .header__auth {
        gap: 12px;
    }
}
</style>
