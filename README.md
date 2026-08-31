# Shop Co

A responsive fashion e-commerce storefront built as a portfolio project on WordPress and WooCommerce.

[English](#english) · [Русский](#русский) · [Development](#development)

## English

### About the project

Shop Co is a full-featured online clothing store focused on a polished shopping experience across desktop and mobile devices. The project covers the complete customer journey: browsing collections and brands, filtering the catalog, viewing configurable products, reading and submitting reviews, and completing the cart and checkout flow.

The storefront is implemented as a custom classic WordPress theme rather than a page-builder configuration. WooCommerce templates and hooks are extended where the design requires custom markup, while native product, order, customer, taxonomy, pricing, inventory, and checkout behavior remains provided by WooCommerce.

Site-specific content structures are separated into the `shop-co-core` plugin. Carbon Fields provides editable home-page hero content and product FAQs, while testimonials are managed through a dedicated custom post type.

### Design attribution

The original UI design is based on the
[E-commerce Website Template — Freebie](https://www.figma.com/design/N3yMmyNjoFZhaIJBq41fkT/E-commerce-Website-Template--Freebie---Community-?node-id=39-1402&p=f&t=ZO1eV5vbSnkO7Y8e-0)
by Hamza Naeem, licensed under
[CC BY 4.0](https://creativecommons.org/licenses/by/4.0/).

The design was adapted and implemented as a custom WordPress/WooCommerce theme for this portfolio project.

### Key features

- Responsive home page with editable hero content, new arrivals, top-selling products, categories, testimonials, and brand links.
- WooCommerce catalog with sorting, pagination, search, sidebar filters, sale products, new-arrival collections, and brand archives.
- Product pages with responsive image galleries, variations, stock and pricing states, product attributes, FAQs, reviews, related products, and upsells.
- Reusable product and testimonial sliders with lazy-loaded JavaScript and CSS-only fallbacks that prevent layout shifts.
- AJAX add-to-cart behavior, mini-cart updates, cart quantity controls, coupons, checkout, and customer account pages.
- WordPress menu-editor integration for adding custom shop collections without hardcoded navigation links.
- Dedicated brands index backed by WooCommerce's native `product_brand` taxonomy.
- Responsive, accessible UI with semantic markup, keyboard-friendly controls, escaped output, and translation-ready strings.

### Architecture and technologies

- **CMS and commerce:** WordPress, WooCommerce, PHP 8.1+.
- **Theme:** custom classic WordPress theme with WooCommerce template overrides, hooks, reusable template parts, and BEM-style component classes.
- **Content plugin:** custom `shop-co-core` plugin with Carbon Fields, product FAQs, editable home-page settings, and testimonial content management.
- **Frontend:** modern JavaScript modules, dynamic imports, SCSS, CSS Grid, Flexbox, responsive fluid sizing, and progressive enhancement.
- **UI libraries:** Swiper, Bootstrap components, noUiSlider, and FsLightbox.
- **Tooling:** `@wordpress/scripts`, Webpack, npm, Composer, WP-CLI, PHP_CodeSniffer, WordPress Coding Standards, and Stylelint.
- **Local environment:** Docker Compose with WordPress, Apache, MariaDB, and phpMyAdmin.

The project favors native WordPress and WooCommerce APIs over one-off implementations. Business content remains editable in the administration area, presentation stays in the theme, and custom data structures live in the core plugin.

## Русский

### О проекте

Shop Co — адаптивный интернет-магазин одежды, разработанный как полноценный портфолио-проект на WordPress и WooCommerce. Проект охватывает весь пользовательский сценарий: просмотр коллекций и брендов, фильтрацию каталога, выбор вариаций товара, работу с отзывами, корзиной и оформлением заказа.

Витрина реализована в виде собственной классической темы WordPress без использования визуального конструктора страниц. В необходимых местах шаблоны и хуки WooCommerce расширены собственной разметкой, при этом товары, заказы, пользователи, цены, остатки, таксономии и checkout продолжают работать на штатной логике WooCommerce.

Специфичные для проекта структуры данных вынесены в отдельный плагин `shop-co-core`. Carbon Fields используется для редактирования hero-секции главной страницы и FAQ товаров, а отзывы покупателей управляются через отдельный тип записей.

### Атрибуция дизайна

Исходный дизайн основан на шаблоне
[E-commerce Website Template — Freebie](https://www.figma.com/design/N3yMmyNjoFZhaIJBq41fkT/E-commerce-Website-Template--Freebie---Community-?node-id=39-1402&p=f&t=ZO1eV5vbSnkO7Y8e-0)
автора Hamza Naeem, распространяемом по лицензии
[CC BY 4.0](https://creativecommons.org/licenses/by/4.0/).

Макет был адаптирован и реализован в виде собственной темы WordPress/WooCommerce для этого портфолио-проекта.

### Основные возможности

- Адаптивная главная страница с редактируемой hero-секцией, новинками, популярными товарами, категориями, отзывами и брендами.
- Каталог WooCommerce с сортировкой, пагинацией, поиском, боковыми фильтрами, товарами со скидкой, новинками и архивами брендов.
- Страница товара с адаптивной галереей, вариациями, ценами и остатками, характеристиками, FAQ, отзывами, похожими и рекомендуемыми товарами.
- Переиспользуемые слайдеры товаров и отзывов с ленивой загрузкой JavaScript и CSS-fallback, предотвращающим скачки разметки.
- AJAX-добавление в корзину, обновление мини-корзины, управление количеством товаров, купоны, checkout и личный кабинет.
- Интеграция со стандартным редактором меню WordPress для добавления специальных коллекций без захардкоженных ссылок.
- Отдельная страница брендов на основе штатной таксономии WooCommerce `product_brand`.
- Адаптивный и доступный интерфейс с семантической разметкой, поддержкой клавиатуры, экранированием вывода и готовностью к переводу.

### Архитектура и технологии

- **CMS и e-commerce:** WordPress, WooCommerce, PHP 8.1+.
- **Тема:** собственная классическая тема WordPress с переопределениями шаблонов WooCommerce, хуками, переиспользуемыми template parts и компонентными BEM-классами.
- **Плагин контента:** собственный `shop-co-core` с Carbon Fields, FAQ товаров, настройками главной страницы и управлением отзывами покупателей.
- **Frontend:** современные JavaScript-модули, динамические импорты, SCSS, CSS Grid, Flexbox, адаптивные fluid-размеры и progressive enhancement.
- **UI-библиотеки:** Swiper, компоненты Bootstrap, noUiSlider и FsLightbox.
- **Инструменты разработки:** `@wordpress/scripts`, Webpack, npm, Composer, WP-CLI, PHP_CodeSniffer, WordPress Coding Standards и Stylelint.
- **Локальное окружение:** Docker Compose с WordPress, Apache, MariaDB и phpMyAdmin.

В проекте предпочтение отдаётся штатным API WordPress и WooCommerce. Контент редактируется в административной панели, представление остаётся в теме, а дополнительные структуры данных находятся в core-плагине.

## Development

### Requirements

- Docker Desktop
- Docker Compose v2
- Make

### Quick start

```bash
make init
make build
make up
make install
make sync-plugins
make theme-install
make theme-build
make wp ARGS='plugin activate woocommerce'
make wp ARGS='plugin activate shop-co-core'
make wp ARGS='theme activate shop-co'
```

WordPress: http://localhost:8080

phpMyAdmin: http://localhost:8081

### Project layout

- `wp-content/themes` - local themes
- `wp-content/plugins` - local plugins and Composer-installed WordPress plugins
- `wp-content/uploads` - local uploads, ignored by git
- `composer.json` - PHP dependencies and WPackagist packages
- `Dockerfile` - WordPress image with Composer and WP-CLI
- `docker-compose.yml` - WordPress, MariaDB, phpMyAdmin
- `Makefile` - common development commands

### Useful commands

```bash
make wp ARGS='plugin list'
make composer ARGS='require wpackagist-plugin/contact-form-7'
make lint-php
make format-php
make theme-install
make theme-build
make theme-watch
make theme-lint-js
make theme-lint-style
make theme-format
make export-db
make import-db
make reset
```
