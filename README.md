# ExoTech - Курсовой проект

Проект с монолитной архитектурой. Сборка экзоскелетов по модулям, управление модулями.

### Запуск

#### dev

Запуск в режиме `npm run dev` с полноценным **hot reload** 🤣.

```sh
docker compose --file docker-compose-dev.yml up -d --build
```

#### builded

Запуск с использованием статичных файлов `npm run build`

```sh
docker compose --file docker-compose-build.yml up -d --build
```

#### только бд

Чтобы запустить только базу данных, а приложение самостоятельно не в контейнере:

```sh
docker compose --file docker-compose-only-db.yml up -d
```

## Команды

```sh
cp .env.example .env
php artisan migrate # либо migrate:fresh, чтобы очистить, а потом заполнить
```

Стэк:

- mysql v8
- Laravel 13 (php 8.4)
    - MoonShine (админ-панель)
- Vue 3 (throught Inertia.js)
    - Pinia
