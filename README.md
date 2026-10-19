# ExoTech

### Запуск

#### dev

Запуск в режиме `npm run dev` с полноценным **hot reload**.

```sh
docker compose --file docker-compose-dev.yml up -d --build
```

#### builded

Запуск с использованием статичных файлов `npm run build`

```sh
docker compose --file docker-compose-build.yml up -d --build
```

Стэк:

- mysql v8
- Laravel 13 (php 8.4)
- Vue 3 (throught Inertia.js)
