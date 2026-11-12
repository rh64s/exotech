<script setup lang="ts">
import { Head, Link, useForm } from '@inertiajs/vue3';
import { store } from '@/actions/App/Http/Controllers/Auth/RegisterController';
import { create as login } from '@/actions/App/Http/Controllers/Auth/LoginController';
import { Button, FormField } from '@/shared/ui';

const form = useForm({
    surname: '',
    name: '',
    patronymic: '',
    phone: '',
    email: '',
    password: '',
    password_confirmation: '',
});

function submit(): void {
    form.post(store.url(), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
}
</script>

<template>
    <Head title="Регистрация" />

    <section class="auth">
        <div class="auth__card">
            <h1 class="text-h3">Регистрация</h1>
            <p class="auth__subtitle">Создайте аккаунт, чтобы собирать свои экзоскелеты.</p>

            <form class="auth__form" @submit.prevent="submit">
                <div class="auth__row">
                    <FormField
                        id="surname"
                        v-model="form.surname"
                        label="Фамилия"
                        autocomplete="family-name"
                        :error="form.errors.surname"
                        required
                        autofocus
                    />
                    <FormField
                        id="name"
                        v-model="form.name"
                        label="Имя"
                        autocomplete="given-name"
                        :error="form.errors.name"
                        required
                    />
                </div>

                <FormField
                    id="patronymic"
                    v-model="form.patronymic"
                    label="Отчество"
                    autocomplete="additional-name"
                    :error="form.errors.patronymic"
                />

                <FormField
                    id="phone"
                    v-model="form.phone"
                    type="tel"
                    label="Телефон"
                    placeholder="79001234567"
                    autocomplete="tel"
                    :error="form.errors.phone"
                    required
                />

                <FormField
                    id="email"
                    v-model="form.email"
                    type="email"
                    label="Email"
                    autocomplete="email"
                    :error="form.errors.email"
                    required
                />

                <div class="auth__row">
                    <FormField
                        id="password"
                        v-model="form.password"
                        type="password"
                        label="Пароль"
                        autocomplete="new-password"
                        :error="form.errors.password"
                        required
                    />
                    <FormField
                        id="password_confirmation"
                        v-model="form.password_confirmation"
                        type="password"
                        label="Повторите пароль"
                        autocomplete="new-password"
                        required
                    />
                </div>

                <Button type="submit" :disabled="form.processing">
                    {{ form.processing ? 'Создаём аккаунт…' : 'Зарегистрироваться' }}
                </Button>
            </form>

            <p class="auth__footer">
                Уже есть аккаунт?
                <Link :href="login.url()" class="auth__link">Войти</Link>
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
    max-width: 640px;
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

.auth__row {
    display: grid;
    grid-template-columns: 1fr 1fr;
    gap: 16px;
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
