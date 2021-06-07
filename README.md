# Internship Backend Skeleton

### Cheatsheet
1. Instalace vagrant pluginů
2. vagrant plugin install vagrant-vbguest
3. vagrant plugin install vagrant-disksize
4. Pouze pro Windows: vagrant plugin install vagrant-winnfsd
5. vagrant up
6. Pokud vyhodí chybu s grub-pc (převážně Windows), tak vagrant ssh a uvnitř spustit DEBIAN_FRONTEND=dialog dpkg --configure grub-pc
7. vagrant ssh
8. cd /var/www/projects
9. git clone https://github.com/b2aswd/internship-backend-skeleton.git
10. cd internship-backend-skeleton
11. docker-compose -p simple_messenger -f docker/docker-compose.yml up -d
12. docker exec -it simple_messenger_backend_1 bash
13. composer install
14. Připojení k databázi v DataGrip
15. Aplikování SQL scriptu (vytvoření databáze a tabulky pro uživatele) přes DataGrip
16. Otevření projektu v PhpStorm
17. Nastavení PHP verzi na 7.4 v PhpStorm
18. Nastavení Xdebug (nástroj pro debugování kódu)


### REST API
https://www.itnetwork.cz/programovani/nezarazene/stoparuv-pruvodce-rest-api

### PHP
https://www.tutorialspoint.com/php/index.htm
https://www.tutorialspoint.com/php-traits

### PostgresSQL
https://www.tutorialspoint.com/postgresql/index.htm

### Phalcon docs
https://docs.phalcon.io/4.0/en/introduction
https://docs.phalcon.io/4.0/cs-cz/db-models
https://docs.phalcon.io/4.0/cs-cz/db-models-validation
https://docs.phalcon.io/4.0/cs-cz/di

### MQTT client library docs
https://github.com/php-mqtt/client