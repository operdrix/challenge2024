# Docker 🐳
build: 
	docker compose build --no-cache
	docker compose up -d 
	docker exec -it challenge_fpm php bin/console doctrine:database:create --if-not-exists
	docker exec -it challenge_fpm php bin/console doctrine:migrations:migrate -n
	docker exec -it challenge_fpm php bin/console doctrine:fixtures:load -n