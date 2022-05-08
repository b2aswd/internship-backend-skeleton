# Internship Backend Skeleton

## Příprava vývojového prostředí
1. Naisntalovat a spustit Visual Studio Code (https://code.visualstudio.com)
2. Nainstalovat rozšíření do Visual Studio Code (Docker, PHP Debug, PostgresSQL) - **viz. video v čase 0:00**
3. Nainstalovat Postman (https://www.postman.com/downloads/)

## Rozjetí projektu
Většina bodů od naklonování jsou ukázána v tomto videu https://www.youtube.com/watch?v=1Znym6HU7KY

**POZOR: Na M1 procesorech je problém s XDebug a je potřeba mít stále zapnutý PHP Debug - viz. video v čase 0:18**
1. Nainstalovat a spustit Docker Desktop
2. Vytvořit si někde složku, do které si následně stáhneme projekt
> mkdir b2a-internship
3. Naklonovat si přes příkazovou řádku projekt z git repozitáře
> git clone https://github.com/b2aswd/internship-backend-skeleton.git
5. Přes příkazovou řádku se přesunout do naklonovaného projektu
> cd internship-backend-skeleton
6. Nainstalovat potřebné závislosti projektu (prvotní spuštění příkazu bude stahovat použité Docker images) - **viz. video v čase 0:26**
> docker-compose -p simple_messenger -f ./docker/docker-compose.yml run backend composer install --prefer-source
7. Spuštění projektu (server, PostgreSQL databáze, MQTT broker) - **viz. video v čase 1:07**
> docker-compose -p simple_messenger -f ./docker/docker-compose.yml up -d
8. Připojení k PostgreSQL databázi (User: messenger, Password: messenger, Database: messenger) - **viz. video v čase 1:18**
9. Aplikování SQL scriptu (vytvoření databáze a tabulky pro uživatele) - **viz. video v čase 1:50**
10. Spustit aplikaci Postman a naimportovat si soubor `postman.json` - **viz. video v čase 2:16**
11. V aplikaci Postman nastavit proměnné prostředí (Environments) - **viz. video v čase 2:30**
12. Přes aplikaci postman si zaregistrovat prvního uživatele a následně přihlásit pro získání API klíče - **viz. video v čase 3:16**
13. Upravit vytvořené proměnné prostředí a přidat API klíč - **viz. video v čase 3:36**
14. Zapnutí debug pro krokování kódu - **viz. video v čase 0:18**
15. Následně v PHP souborech najet na číslo požadovaného řádku a vlevo od něj kliknout na červenou tečku. Tímto se průchod kódem zastaví na tomto řádku, pokud spustíme endpoint, který tímto souborem prochází


## Po zapnutí PC
1. Spustit Docker Desktop
2. Přes příkazovou řádku přejít do složky **internship-backend-skeleton**
> cd cd internship-backend-skeleton
3. Spuštění projektu (server, PostgreSQL databáze, MQTT broker)
> docker-compose -p simple_messenger -f ./docker/docker-compose.yml up -d

## Zadání
- Vytvořit Controller, Model a případně Mapper pro ChatRoom modul (např. adresář `app/ChatRoom`)
- Důležité upravit soubor `public/index.php`, ve kterém je třeba přidat nově přidaný modul
- ChatRoom by měl obsahovat název, popis a případně kdo jej vytvořil (podobně jako tomu je u modulu User - `createdById`)
- Vytvořit Controller, Model a případně Mapper pro Message modul (např. pro Controller `app/ChatRoom/Controller/ChatRoom/MessageController.php` nebo jako samostatný modul)
- Message by měla obsahovat vazbu na ChatRoom, obsah zprávy a případně kdo ji vytvořil (podobně jako tomu je u modulu User - `createdById`)

## Rozšiřující zadání
- Dále je možné dodělat třídu MqttService (`app/Core/Service/MqttService.php`), kde je potřeba vytvořit metodu pro připojení a publikování zprávy (ukázka připojení a publikování zprávy je v dokumentaci použité knihovny - odkaz níže)
- Po dokončení této třídy je třeba v Controlleru při akci vytvoření nebo na modelu zprávy (`afterCreate` metoda podle dokumentace) získat třídu MqttService (`$mqttService = $this->getDI()->getShared(\SimpleMessenger\Core\Service\MqttService::class);`) a zavolat na ní metodu pro publikování
- MQTT zpráva by měla obsahovat JSON informací o zprávě (např. vytvoření instance mapperu a zavolání map metody, do
  které se předá vytvořená zpráva) - zde je ukázka obsahu MQTT zprávy
```JSON
{
    "id": 4,
    "chatRoom": {
        "id": 2,
        "title": "Test room",
        "description": "update",
        "created": "2021-06-06T21:17:39.000Z",
        "createdBy": {
            "id": 1,
            "name": "Admin",
            "surname": "B2A",
            "email": "admin@b2a.cz",
            "created": "2021-06-06T21:16:06.000Z",
            "createdBy": null,
            "updated": null,
            "updatedBy": null
        },
        "updated": "2021-06-06T22:02:33.000Z",
        "updatedBy": {
            "id": 1,
            "name": "Admin",
            "surname": "B2A",
            "email": "admin@b2a.cz",
            "created": "2021-06-06T21:16:06.000Z",
            "createdBy": null,
            "updated": null,
            "updatedBy": null
        }
    },
    "content": "Test message",
    "created": "2021-06-06T22:22:56.000Z",
    "createdBy": {
        "id": 1,
        "name": "Admin",
        "surname": "B2A",
        "email": "admin@b2a.cz",
        "created": "2021-06-06T21:16:06.000Z",
        "createdBy": null,
        "updated": null,
        "updatedBy": null
    },
    "updated": null,
    "updatedBy": null
}
```

- Vytvoření funkce pro sledování místnosti, kdy se MQTT zpráva odešle pouze uživatelům, kteří danou místnost sledují. V takovém případě je potřeba:
  - Vytvořit novou tabulku v databázi (`chat_room_watch`), která bude obsahovat `user_id` s FOREIGN KEY na tabulku user a `chat_room_id` s FOREIGN KEY na tabulku s místnostmi
  - Vytvořit nový model Watch, který bude obsahovat jednak metody pro získání a nastavení uživatele či místnosti (`getUser`, `setUser`, `getChatRoom`, `setChatRoom`) - opět se lze inspirovat např. `createdBy`
  - V modelu vytvořit statickou metodu `findAllWatchersForChatRoom` (`public static function findAllWatchersForChatRoom (\Forum\ChatRoom\Model\ChatRoom $chatRoom)`), která pro danou místnost předanou v argumentu najde všechny uživatele (lze využít metodu find na modelu a podmínek pro vyhledání, více na tomto odkazu: [https://docs.phalcon.io/4.0/cs-cz/db-models](https://docs.phalcon.io/4.0/cs-cz/db-models))
  - V modelu vytvořit statickou metodu `findForUserAndChatRoom` (`public static function findForUserAndChatRoom(\Forum\User\Model\User $user, \Forum\ChatRoom\Model\ChatRoom $chatRoom)`), které se předá uživatel a místnost a podobně jako v předchozím bodě se využije metody find a conditions (ukázky jsou na odkaze)
  - Vytvořit nový controller `WatchController`, který bude obsahovat dvě akce (`watchAction`, `unwatchAction`), kde v argumentu bude ID místnosti
      - `watchAction` - první je potřeba najít místnost (metoda `findFirst` na modelu místnosti, které se dává ID místnosti), následně je potřeba vytvořit nový model Watch, kterému se nastaví ta místnost a přihlášení uživatel přes `$this->user`, následně se na modelu Watch zavolá metoda save
      - `unwatchAction` - první je potřeba najít místnost (metoda `findFirst` na modelu místnosti, které se dává ID místnosti), následně je potřeba na modelu watch zavolat metodu findForUserAndChatRoom, které se předá místnost a uživatel přes `$this->user`, pokud je nalezen záznam (model), je na něm zavolána metoda delete - v opačném případě se nic neděje
      - Routes můžou být například - `/api/v1/chat-room/:idChatroom/watch` (`/api/v1/chat-room/1/watch`)
  - Je potřeba upravit místo, kde dochází k odesílání MQTT zprávy tak, že je první zavolána metoda `findAllWatchersForChatRoom` na Watch modelu, které je předána místnost - následně vrácené modely uživatelů jsou projíty přes foreach a MQTT zpráva se pošle na topic `chat-room/watch/user/:idUser` (`chat-room/watch/user/1`)

## REST API
- https://www.itnetwork.cz/programovani/nezarazene/stoparuv-pruvodce-rest-api

## PHP
- https://www.tutorialspoint.com/php/index.htm
- https://www.tutorialspoint.com/php-traits

## PostgreSQL
- https://www.tutorialspoint.com/postgresql/index.htm

## Phalcon docs
- https://docs.phalcon.io/4.0/en/introduction
- https://docs.phalcon.io/4.0/cs-cz/db-models
- https://docs.phalcon.io/4.0/cs-cz/db-models-validation
- https://docs.phalcon.io/4.0/cs-cz/di

## MQTT client library docs
- https://github.com/php-mqtt/client

## Docker & Docker Compose
- https://docs.docker.com
- https://docs.docker.com/compose/