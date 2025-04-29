# Meme Swipe – Tinder для мемов 🚀

<div align="center">
  <img src="https://media.giphy.com/media/Ln2dAW9oycjgmTpjX9/giphy.gif" width="200" alt="Meme Swipe Logo" />
  <h1>Открывайте мемы по-новому</h1>
  <p>Свайпайте, сохраняйте, делитесь и находите единомышленников!</p>

<a href="https://laravel.com"><img src="https://img.shields.io/badge/Laravel-FF2D20?style=for-the-badge&logo=laravel&logoColor=white" /></a>
<a href="https://www.docker.com/"><img src="https://img.shields.io/badge/Docker-2496ED?style=for-the-badge&logo=docker&logoColor=white" /></a>
<a href="https://tailwindcss.com/"><img src="https://img.shields.io/badge/Tailwind_CSS-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white" /></a>
</div>

---

## 🌟 Особенности

- 🎭 **Tinder-подобный интерфейс** для свайпа мемов
- ❤️ **Алгоритм рекомендаций**, основанный на ваших лайках и дизлайках
- ⭐ **Система "Избранное"** — сохраняйте лучшие мемы для себя
- 🤝 **Совпадения** — находите людей с похожим чувством юмора
- 📊 **Статистика** вашей активности и популярных мемов
- 📱 **Кроссплатформенность** — доступно на всех устройствах

---

## 🛠 Технологический стек

| Компонент       | Технология              |
|-----------------|-------------------------|
| **Backend**     | Laravel 12              |
| **Frontend**    | Blade + Tailwind CSS    |
| **Интерактивность** | Alpine.js + Livewire    |
| **База данных** | MySQL                   |
| **Аутентификация** | Laravel Breeze          |
| **Развертывание** | Docker + Docker Compose |

---

## 🚀 Быстрый старт

### 📋 Требования

- PHP 8.2+
- Docker и Docker Compose
- Composer
- Node.js и npm

### 🔧 Установка

1. **Клонируйте репозиторий**:
    ```bash
    git clone https://github.com/elitekbtu/tinder.git
    cd tinder
    ```

2. **Скопируйте файл окружения**:
    ```bash
    cp .env.example .env
    ```

3. **Запустите контейнеры**:
    ```bash
    docker-compose up --build -d
    ```

4. **Установите зависимости**:
    ```bash
    docker-compose run composer install
    ```

5. **Выполните миграции и сидеры и сгенерируйте ключ приложения**:
    ```bash
    docker-compose run artisan migrate --seed
    docker-compose run artisan key:generate
    ```

6. **Соберите фронтенд**:
    ```bash
    cd src
    npm install 
    npm run build
    npm run dev
    ```

7. **Откройте приложение в браузере**:
    ```
    http://localhost:8000
    ```

---

## 📁 Структура проекта

```plaintext
meme-swipe/
├── docker/                    # Docker конфигурации
│   ├── dockerfiles/           # Docker файлы
│   ├── nginx/                 # Конфигурация Nginx
│   └── env/                   # Файлы окружения
├── src/                       # Основной код проекта
│   ├── app/                   # Ядро приложения
│   │   ├── Http/Controllers/  # Контроллеры 
│   │   ├── Models/            # Модели 
│   │   └── View/Components/   # Blade компоненты 
│   ├── bootstrap/             # Файлы инициализации 
│   ├── config/                # Конфигурации приложения 
│   ├── database/              # Работа с БД
│   │   ├── migrations/        # Миграции 
│   │   └── seeders/           # Сидеры 
│   ├── public/                # Публичные ресурсы 
│   ├── resources/             # Фронтенд ресурсы
│   │   ├── js/                # JavaScript 
│   │   ├── css/               # Стили
│   │   └── views/             # Blade шаблоны 
│   ├── routes/                # Маршруты 
│   ├── storage/               # Файловое хранилище 
│   └── tests/                 # Тесты 
├── vendor/                    # Зависимости Composer
├── docker-compose.yml         # Docker Compose конфиг
```

---

## 🏗️ Процесс проектирования и разработки

Проект разрабатывался с акцентом на удобство пользователя и масштабируемость. Для обеспечения плавного пользовательского опыта использовались:

1. **Итеративная разработка**: Новый функционал добавлялся поэтапно.
2. **Тестирование**: Каждая итерация функционала тестировалась
3. **Модульный подход**: Код организован по принципу "одна задача — один модуль".
4. **Контейнеризация**: Docker обеспечил единое окружение для разработки и продакшена.

---

## 🧠 Уникальные подходы и методологии

- **Рекомендательная система**: Используется алгоритм, анализирующий лайки и дизлайки пользователей для подбора подходящих мемов.
- **Оптимизация запросов**: Для снижения нагрузки на сервер применены кэширование и оптимизация SQL-запросов.
- **Фронтенд-микроанимации**: Alpine.js позволил реализовать лёгкие анимации и интерактивные элементы.

---


## 🐞 Известные ошибки и проблемы


1. **Деплой**: Многие бесплатные сервисы не позволяют длительно работать с Laravel, очень большая нагрузка на сервер.

---

## 🔍 Почему мы выбрали этот стек?

- **Laravel**: Простота, богатый функционал и поддержка сообщества.
- **Tailwind CSS**: Быстрое создание адаптивного дизайна.
- **MySQL**: Надёжность и производительность для работы с рекомендациями.
- **Docker**: Упрощённая разработка и деплой благодаря контейнеризации.
- **Alpine.js**: Минималистичный, но мощный инструмент для интерактивности.


## 🎨 Скриншоты

<div align="center">
  <a href="https://drive.google.com/file/d/1QvjccoDHLunGZ3TWGdc3_Nwy4LuITBeE/view?usp=sharing" target="_blank">
    <img src="https://drive.google.com/thumbnail?id=1QvjccoDHLunGZ3TWGdc3_Nwy4LuITBeE&sz=w400" width="30%" alt="Главный экран" />
  </a>
  <a href="https://drive.google.com/file/d/1RAtgMpPeXPX3gCkMJ9gBr8fdZ499HFNF/view?usp=sharing" target="_blank">
    <img src="https://drive.google.com/thumbnail?id=1RAtgMpPeXPX3gCkMJ9gBr8fdZ499HFNF&sz=w400" width="30%" height="50%" alt="Свайп мемов" />
  </a>
  <a href="https://drive.google.com/file/d/1u8VHVbKpQvNgS_uaiyOZ1m3PnLzdBA3y/view?usp=sharing" target="_blank">
    <img src="https://drive.google.com/thumbnail?id=1u8VHVbKpQvNgS_uaiyOZ1m3PnLzdBA3y&sz=w400" width="30%" alt="Статистика" />
  </a>
</div>

## 🎨 Видео-обзор функционала

[Первое видео](https://www.loom.com/share/96b7191542a34809af41022b87de905f?sid=ad82eae5-0b7e-4120-af85-91e7f33b47a6)  
[Второе видео](https://www.loom.com/share/ddc8709e34904fd7a1063f251b43da1b?sid=6d395a2f-92fb-4ebf-b34f-b7e56db3d951)