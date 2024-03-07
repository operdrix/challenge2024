# Docker 🐳
build:
	clear
	@echo "Installation de l'application EduMentor..."
	@echo "🐳 Building Docker containers..."
	#docker compose build --no-cache
	docker compose up -d
	docker exec -it challenge_fpm composer install
	docker exec -it challenge_fpm npm install
	docker exec -it challenge_fpm npm run dev
	docker exec -it challenge_fpm php bin/console doctrine:database:create --if-not-exists
	docker exec -it challenge_fpm php bin/console doctrine:migrations:migrate -n
	docker exec -it challenge_fpm php bin/console doctrine:fixtures:load -n
	clear
	clear
	@echo ""
	@echo "\033[0;34m░▒▓████████▓▒░▒▓███████▓▒░░▒▓█▓▒░░▒▓█▓▒░▒▓██████████████▓▒░\033[0m\033[38;2;103;148;54m░▒▓████████▓▒░▒▓███████▓▒░\033[0m\033[0;34m▒▓████████▓▒░▒▓██████▓▒░░▒▓███████▓▒░  \033[0m"
	@echo "\033[0;34m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░  ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░ \033[0m"
	@echo "\033[0;34m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░  ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░ \033[0m"
	@echo "\033[0;34m░▒▓██████▓▒░ ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓██████▓▒░ ░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░  ░▒▓█▓▒░░▒▓█▓▒░▒▓███████▓▒░  \033[0m"
	@echo "\033[0;34m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░  ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░ \033[0m"
	@echo "\033[0;34m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓█▓▒░      ░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░  ░▒▓█▓▒░░▒▓█▓▒░▒▓█▓▒░░▒▓█▓▒░ \033[0m"
	@echo "\033[0;34m░▒▓████████▓▒░▒▓███████▓▒░ ░▒▓██████▓▒░░▒▓█▓▒░░▒▓█▓▒░░▒▓█▓▒\033[0m\033[38;2;103;148;54m░▒▓████████▓▒░▒▓█▓▒░░▒▓█▓▒░ \033[0m\033[0;34m░▒▓█▓▒░   ░▒▓██████▓▒░░▒▓█▓▒░░▒▓█▓▒░ \033[0m"
	@echo "\033[0m"
	@echo "================================ EduMentor ================================"
	@echo "Installation terminée avec succès !"
	@echo "Connectez-vous à l'application via : http://localhost"
	@echo "Accédez à phpMyAdmin ici : http://localhost:8080"
	@echo "Accédez au terminal du conteneur php : \033[38;5;39m\033[1m\033[3m docker\033[0m compose exec php /bin/bash"
	@echo "==========================================================================="
	@echo ""
	@echo "      \e[48;2;0;87;183m     Stand For      \033[0m"
	@echo "      \e[48;2;255;215;0m\e[38;2;0;87;183m      Ukraine       \033[0m"
	@echo ""
