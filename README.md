# Shop Co

Local WordPress + WooCommerce environment for portfolio development.

## Requirements

- Docker Desktop
- Docker Compose v2
- Make

## Quick start

```bash
make init
make build
make up
make install
```

WordPress: http://localhost:8080

phpMyAdmin: http://localhost:8081

## Project layout

- `wp-content/themes` - local themes
- `wp-content/plugins` - local plugins and Composer-installed WordPress plugins
- `wp-content/uploads` - local uploads, ignored by git
- `composer.json` - PHP dependencies and WPackagist packages
- `Dockerfile` - WordPress image with Composer and WP-CLI
- `docker-compose.yml` - WordPress, MariaDB, phpMyAdmin
- `Makefile` - common development commands

## Useful commands

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
