# Casexe PHP 7.0

- PHP 7.0
- MySQL 5.7
- Apache 2.4
- PDO
- composer (only for composer::autoload)
- bootstrap 4.0 / jQuery 1.12 (CDN)

Everything is written from zero state, nothing is stolen...

## Done for now

- core
- login/logout
- lottery play
- accept/reject/convert prize
- withdraw EURO prize to creditCard
- admin panel - set status SENT for item prizes and transfer EURO for winners
- CLI - migrations, cli command for transfer all confirmed payments (can be used by Crontab)

### Installing

Clone repository

```
git clone https://github.com/AzGothic/casexe-php.git /path/to/project
```

Install composer

```
composer install
```

Set local configs to /config/ directory, examples in

```
/samples/config/
```

Use migration tool for creating DB structure and needed data

```
php app migrate
```

### Usage

Path to public:

```
http://site
```

Test users:
- Email `user1@example.com`, password `111111`
- Email `user2@example.com`, password `111111`
- Email `user3@example.com`, password `111111`

Path to admin panel:

```
http://site/admin
```

Test admin:
- Email `admin@example.com`, password `111111`

Run transfer payments from command line:

```
php app transfer {LIMIT}
```

## Project structure

    .
    ├── base                    # base application directory, core
    ├── config                  # configs
    ├── controller              # controllers for web
    │   └── base                # base controllers
    ├── command                 # controllers for cli
    ├── view                    # views for web
    ├── model                   # models
    ├── web                     # public directory for web
    ├── module                  # modules
    ├── migrate                 # DB migrations
    ├── vendor                  # composer vendors directory
    ├── samples                 # examples for install project
    │   └── config              # local config files
    ├── bootstrap.php           # main loader file
    ├── composer.json           # composer config
    ├── composer.lock           # composer installed packages config
    ├── app                     # cli loader
    ├── app.bat                 # batch cli loader for Windows
    ├── .gitignore
    └── README.md

## DB structure

    .
    ├── user                    # users table
    ├── admin                   # admin users table
    ├── options                 # configurations for lottery
    ├── items                   # items for lottery
    ├── winners                 # winners table included user id, type of prize, value/item id
    └── migration_casexe        # technical table for migrations check

## Extra

Migrations create

```
php app migrate/create {NAME}
```