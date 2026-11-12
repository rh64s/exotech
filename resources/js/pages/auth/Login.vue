<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/Auth/LoginController';
import { create as register } from '@/actions/App/Http/Controllers/Auth/RegisterController';
import { Button, FormField } from '@/shared/ui';

const form = useForm({
    login: '',
    password: '',
    remember: false,
});

function submit(): void {
    form.post(store.url(), {
        onFinish: () => form.reset('password'),
    });
}
</script>

<template>
    <Head title="Вход" />

    <section class="auth">
        <div class="auth__card">
            <h1 class="text-h3">Вход</h1>
            <p class="auth__subtitle">Войдите по email или номеру телефона.</p>

            <form class="auth__form" @submit.prevent="submit">
                <FormField
                    id="login"
                    v-model="form.login"
                    label="Email или телефон"
                    autocomplete="username"
                    :error="form.errors.login"
                    required
                    autofocus
                />

                <FormField
                    id="password"
                    v-model="form.password"
                    type="password"
                    label="Пароль"
                    autocomplete="current-password"
                    :error="form.errors.password"
                    required
                />

                <label class="auth__remember">
                    <input v-model="form.remember" type="checkbox" />
                    <span>Запомнить меня</span>
                </label>

                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Входим…' : 'Войти' }}
                </Button>
            </form>

            <p class="auth__footer">
                Нет аккаунта?
                <Link :href="register.url()" class="auth__link">Зарегистрироваться</Link>
            </p>
        </div>
    </section>
</template>

<style scoped>
.auth {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    padding: 48px 0;
}

.auth__card {
    display: flex;
    flex-direction: column;
    gap: 16px;
    width: 100%;
    max-width: 440px;
    padding: 40px;
    border: 1px solid var(--color-mid);
    border-radius: 24px;
    background: var(--gradient-primary);
    color: var(--color-primary);
    box-shadow: var(--shadow);
}

.auth__subtitle {
    color: var(--color-second);
}

.auth__form {
    display: flex;
    flex-direction: column;
    gap: 16px;
}

.auth__remember {
    display: flex;
    align-items: center;
    gap: 8px;
    color: var(--color-second);
    font-size: var(--text-p);
    cursor: pointer;
}

.auth__remember input {
    width: 16px;
    height: 16px;
    accent-color: var(--color-accent);
}

.auth__footer {
    color: var(--color-second);
}

.auth__link {
    color: var(--color-accent);
    text-decoration: underline;
}

.auth__link:hover {
    color: var(--color-hover);
}
</style>
