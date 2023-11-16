include .env

install:
	@$(MAKE) -s down
	@$(MAKE) -s docker-build
	@$(MAKE) -s up
	@$(MAKE) -s composer-install
	@$(MAKE) -s migrate
	@$(MAKE) -s spa-install
	@$(MAKE) -s spa-build

up: docker-up
down: docker-down
ps:
	@docker-compose ps

docker-up:
	@docker-compose -p ${INDEX} up -d

docker-down:
	@docker-compose -p ${INDEX} down --remove-orphans

docker-build: \
	docker-build-app-php-cli \
	docker-build-app-php-fpm \
	docker-build-app-nginx

docker-build-app-nginx:
	@docker build --target=nginx \
	-t ${REGISTRY}/${INDEX}-nginx:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-build-app-php-fpm:
	@docker build --target=fpm \
	-t ${REGISTRY}/${INDEX}-php-fpm:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-build-app-php-cli:
	@docker build --target=cli \
	-t ${REGISTRY}/${INDEX}-php-cli:${IMAGE_TAG} -f ./docker/Dockerfile .

docker-logs:
	@docker-compose -p ${INDEX} logs -f

app-php-cli-exec:
	@docker-compose -p ${INDEX} run --rm php-cli $(cmd)

migrate:
	$(MAKE) app-php-cli-exec cmd="php ./yii migrate"

composer-install:
	$(MAKE) app-php-cli-exec cmd="composer install"

spa-install:
	@docker build --build-arg USER=$(whoami) --build-arg GROUP=$(whoami) \
	-t ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} -f ./docker/Dockerfile .
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} yarn

spa-add:
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} yarn add $(pkg)

spa-remove:
	@docker run --rm -v $(PWD)/frontend:/app ${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} yarn remove $(pkg)

spa-build:
	@rm -rf ./web/assets ./web/js
	@docker run --rm -v $(PWD)/frontend:/app -v $(PWD)/web:/app-web \
		-e API_AUTH_KEY=${API_AUTH_KEY} \
		-e API_BASE_URL=http://localhost:${APP_WEB_PORT}${API_BASE_URL} \
	${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} yarn run build

spa-dev-up:
	@$(MAKE) -s up
	@rm -rf ./web/assets ./web/js
	@docker run --rm -d -v $(PWD)/frontend:/app -v $(PWD)/web:/app-web \
		--name ${INDEX}-spa-dev \
		-p ${SPA_DEV_PORT}:5173 \
		-e API_AUTH_KEY=${API_AUTH_KEY} \
		-e API_BASE_URL=http://localhost:${APP_WEB_PORT}${API_BASE_URL} \
		${REGISTRY}/${INDEX}-spa:${IMAGE_TAG} yarn run dev && \
	echo "\033[0;32mSPA приложение запущено в режиме разработки по адресу http://localhost:${SPA_DEV_PORT}\033[0m\n\033[0;33mПо готовности доработок завершите режим разработки командой make spa-dev-down\033[0m"

spa-dev-down:
	@$(MAKE) -s down
	@docker stop ${INDEX}-spa-dev && \
	echo "\033[0;32mРежим разработки SPA приложения остановлен.\033[0m\n\033[0;33mДля сборки production-ready SPA приложения выполните команду make spa-build\033[0m"