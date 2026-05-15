DOCKER_COMPOSE ?= docker compose
WP_SERVICE ?= wordpress
PROJECT_DIR ?= /var/www/project
THEME_DIR ?= wp-content/themes/shop-co
NPM ?= npm.cmd

SHELL := powershell.exe
.SHELLFLAGS := -NoProfile -Command

.DEFAULT_GOAL := help

.PHONY: help init build up down restart ps logs shell wp composer install update lint-php format-php theme-install theme-clean theme-build theme-watch theme-lint-js theme-lint-style theme-format db import-db export-db reset clean

help:
	@echo "Available commands:"
	@echo "  make init       Copy .env.example to .env and create wp-content dirs"
	@echo "  make build      Build Docker images"
	@echo "  make up         Start containers in background"
	@echo "  make down       Stop containers"
	@echo "  make restart    Restart containers"
	@echo "  make ps         Show containers"
	@echo "  make logs       Follow WordPress logs"
	@echo "  make shell      Open shell in WordPress container"
	@echo "  make wp ARGS='plugin list'      Run WP-CLI"
	@echo "  make composer ARGS='install'    Run Composer"
	@echo "  make install    Install Composer dependencies"
	@echo "  make update     Update Composer dependencies"
	@echo "  make lint-php   Run PHP_CodeSniffer with WordPress standards"
	@echo "  make format-php Auto-fix PHP coding standard issues"
	@echo "  make theme-install  Install theme npm dependencies"
	@echo "  make theme-clean    Remove built theme assets"
	@echo "  make theme-build    Build theme assets"
	@echo "  make theme-watch    Watch theme assets"
	@echo "  make theme-lint-js     Lint theme JavaScript"
	@echo "  make theme-lint-style  Lint theme SCSS"
	@echo "  make theme-format      Format theme JS/SCSS/JSON"
	@echo "  make db         Open MySQL client"
	@echo "  make export-db  Export DB to backup.sql"
	@echo "  make import-db  Import DB from backup.sql"
	@echo "  make reset      Stop and remove containers with volumes"
	@echo "  make clean      Remove generated local WordPress cache/upload dirs"

init:
	if (-not (Test-Path .env)) { Copy-Item .env.example .env }
	New-Item -ItemType Directory -Force wp-content/themes, wp-content/plugins, wp-content/uploads | Out-Null

build:
	$(DOCKER_COMPOSE) build

up:
	$(DOCKER_COMPOSE) up -d

down:
	$(DOCKER_COMPOSE) down

restart:
	$(DOCKER_COMPOSE) restart

ps:
	$(DOCKER_COMPOSE) ps

logs:
	$(DOCKER_COMPOSE) logs -f $(WP_SERVICE)

shell:
	$(DOCKER_COMPOSE) exec $(WP_SERVICE) bash

wp:
	$(DOCKER_COMPOSE) exec -w /var/www/html $(WP_SERVICE) wp --allow-root $(ARGS)

composer:
	$(DOCKER_COMPOSE) exec -w $(PROJECT_DIR) $(WP_SERVICE) composer $(ARGS)

install:
	$(DOCKER_COMPOSE) exec -w $(PROJECT_DIR) $(WP_SERVICE) composer install

update:
	$(DOCKER_COMPOSE) exec -w $(PROJECT_DIR) $(WP_SERVICE) composer update

lint-php:
	$(DOCKER_COMPOSE) exec -w $(PROJECT_DIR) $(WP_SERVICE) composer lint:php

format-php:
	$(DOCKER_COMPOSE) exec -w $(PROJECT_DIR) $(WP_SERVICE) composer format:php

theme-install:
	$(NPM) --prefix $(THEME_DIR) install

theme-clean:
	Remove-Item -Recurse -Force $(THEME_DIR)/build -ErrorAction SilentlyContinue

theme-build: theme-clean
	$(NPM) --prefix $(THEME_DIR) run build

theme-watch:
	$(NPM) --prefix $(THEME_DIR) run start

theme-lint-js:
	$(NPM) --prefix $(THEME_DIR) run lint:js

theme-lint-style:
	$(NPM) --prefix $(THEME_DIR) run lint:style

theme-format:
	$(NPM) --prefix $(THEME_DIR) run format

db:
	$(DOCKER_COMPOSE) exec db sh -c 'mariadb -u root -p"$$MARIADB_ROOT_PASSWORD" "$$MARIADB_DATABASE"'

export-db:
	$(DOCKER_COMPOSE) exec db sh -c 'mariadb-dump -u root -p"$$MARIADB_ROOT_PASSWORD" "$$MARIADB_DATABASE"' | Set-Content -Encoding UTF8 backup.sql

import-db:
	Get-Content backup.sql | $(DOCKER_COMPOSE) exec -T db sh -c 'mariadb -u root -p"$$MARIADB_ROOT_PASSWORD" "$$MARIADB_DATABASE"'

reset:
	$(DOCKER_COMPOSE) down -v --remove-orphans

clean:
	Remove-Item -Recurse -Force wp-content/cache, wp-content/upgrade -ErrorAction SilentlyContinue
