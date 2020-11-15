.PHONY: build check clean deploy-prod deploy-stage install outdated start stop upgrade watch

# install at first, as make without args will execute first entry
install:
	@composer install
	@yarn
	@make outdated
	@bin/console doctrine:migrations:status

build:
#	@rm rev-manifest.json
	@gulp
#	//@mv rev-manifest.json path/to/rev-manifest.json

check:
	@composer diagnose; exit 0
	@composer validate
	@bin/security-checker security:check composer.lock
	@node_modules/package-json-validator/bin/pjv -q package.json
#	@gulp --verify

diff:
	@bin/console doctrine:migrations:diff

status:
	@bin/console doctrine:migrations:status

migrate:
	@bin/console doctrine:migrations:migrate

clean:
	@rm -rf var/cache/*
	@rm -rf var/logs/*
	@rm -rf node_modules
	@rm -rf vendor

deploy-prod:
	@echo "Just merge on master branch ;)"

deploy-stage:
	@bin/deploy-stage.sh

outdated: check
	@composer outdated
	@yarn outdated; exit 0

start:
	@bin/console server:start --env=dev

stop:
	@bin/console server:stop --env=dev

restart:
	@bin/console server:stop --env=dev
	@bin/console server:start --env=dev

upgrade:
	@composer update
	@composer outdated
	@yarn upgrade
	@yarn
	@yarn outdated
	@make check

watch:
	@./node_modules/.bin/gulp watch

pull:
	@git pull
	@bin/console doctrine:migration:status