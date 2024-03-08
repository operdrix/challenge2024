# Docker 🐳
build:
	clear
	@echo "Installation de l'application EduMentor..."
	@echo "🐳 Building Docker containers..."
	docker compose build --no-cache
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
	@echo "Installation terminée avec \033[38;2;103;148;54msuccès !\033[0m"
	@echo "Connectez-vous à l'application via : http://localhost"
	@echo "Accédez à phpMyAdmin ici : http://localhost:8080"
	@echo "Accédez au service MailCatcher ici : http://localhost:1080"
	@echo "Accédez au terminal du conteneur php : \`\033[38;5;39m\033[1m\033[3mdocker\033[0m compose exec php /bin/bash\`"
	@echo "N'oubliez pas de lancer la commande \`\033[38;5;39m\033[1m\033[3mnpm\033[0m run watch\` pour compiler les assets en temps réel"
	@echo "==========================================================================="
	@echo ""
	@echo "      \033[48;2;0;87;183m     Stand For      \033[0m"
	@echo "      \033[48;2;255;215;0m\033[38;2;0;87;183m      Ukraine       \033[0m"
	@echo ""
