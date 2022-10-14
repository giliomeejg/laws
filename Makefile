.PHONY: up
up:
	./vendor/bin/sail up

.PHONY: down
down:
	./vendor/bin/sail down

.PHONY: build
build:
	./vendor/bin/sail build --no-cache

.PHONY: test-phpunit
test-phpunit:
	docker-compose exec laws vendor/bin/phpunit

.PHONY: test-dusk
test-dusk:
	./vendor/bin/sail dusk

.PHONY: in
in:
	docker exec -it laws /bin/bash


.PHONY: sail
sail:
	alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'



