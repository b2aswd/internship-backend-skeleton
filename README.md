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

### Po zapnutí PC
1. Ve složce s workspace, kde se nachází *Vagrantfile*, je potřeba přes příkazovou řádku spustit **vagrant up** a následně **vagrant ssh**
2. cd /var/www/projects/internship-backend-skeleton
3. docker-compose -p simple_messenger -f docker/docker-compose.yml up -d

### Zadání
- Vytvořit Controller, Model a případně Mapper pro ChatRoom modul (např. adresář app/ChatRoom)
- Důležité upravit soubor **public/index.php**, ve kterém je třeba přidat nově přidaný modul
- ChatRoom by měl obsahovat název, popis a případně kdo jej vytvořil (podobně jako tomu je u modulu User - createdById)
- Vytvořit Controller, Model a případně Mapper pro Message modul (např. pro Controller app/ChatRoom/Controller/ChatRoom/MessageController.php nebo jako samostatný modul)
- Message by měla obsahovat vazbu na ChatRoom, obsah zprávy a případně kdo ji vytvořil (podobně jako tomu je u modulu User - createdById)
- Dále je možné dodělat třídu MqttService (app/Core/Service/MqttService.php), kde je potřeba vytvořit metodu pro připojení a publikování zprávy
- Po dokončení této třídy je třeba v Controlleru při akci vytvoření nebo na modelu zprávy (afterCreate metoda podle dokumentace)
získat třídu MqttService (**$mqttService = $this->getDI()->getShared(\SimpleMessenger\Core\Service\MqttService::class);**) a zavolat na ní metodu pro publikování
- MQTT zpráva by měla obsahovat json (pole) informací o zprávě (např. vytvoření instance mapperu a zavolání map metody, do které se předá vytvořená zpráva)

### REST API
- https://www.itnetwork.cz/programovani/nezarazene/stoparuv-pruvodce-rest-api

### PHP
- https://www.tutorialspoint.com/php/index.htm
- https://www.tutorialspoint.com/php-traits

### PostgresSQL
- https://www.tutorialspoint.com/postgresql/index.htm

### Phalcon docs
- https://docs.phalcon.io/4.0/en/introduction
- https://docs.phalcon.io/4.0/cs-cz/db-models
- https://docs.phalcon.io/4.0/cs-cz/db-models-validation
- https://docs.phalcon.io/4.0/cs-cz/di

### MQTT client library docs
- https://github.com/php-mqtt/client