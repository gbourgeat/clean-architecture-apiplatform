DC = DOCKER_BUILDKIT=1 docker-compose
EXEC = $(DC) exec api_php
COMPOSER = $(EXEC) composer

php:
	@$(EXEC) sh

install:
	@$(MAKE) generate-localhost-certs
	@$(MAKE) generate-jwt-keypair
	@$(DC) build
	@$(MAKE) start -s
	@$(MAKE) vendor -s
	@$(MAKE) db-reset -s

generate-localhost-certs:
	sh generate-localhost-certs.sh

generate-jwt-keypair:
	sh generate-jwt-keypair.sh

vendor:
	@$(COMPOSER) install --optimize-autoloader

start:
	@$(DC) up -d --remove-orphans --no-recreate

stop:
	@$(DC) kill
	@$(DC) rm -v --force

.PHONY: php install generate-localhost-certs generate-jwt-keypair vendor start stop

db-create:
	@$(EXEC) bin/console doctrine:database:drop --force --if-exists -nq
	@$(EXEC) bin/console doctrine:database:create -nq

db-update:
	@$(EXEC) bin/console doctrine:schema:update --force -nq

db-reset: db-create db-update

.PHONY: db-create db-update db-reset

tests:
	@$(EXEC) bin/console doctrine:database:drop --force --env=test || true
	@$(EXEC) bin/console doctrine:database:create --env=test
	@$(EXEC) bin/console doctrine:schema:create --env=test
	@$(EXEC) bin/phpunit $@

.PHONY: tests
