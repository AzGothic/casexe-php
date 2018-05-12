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

Dump for MySQL DB

```
/samples/sql.sql
```

Test users:
- Email `user1@example.com`, password `111111`
- Email `user2@example.com`, password `111111`
- Email `user3@example.com`, password `111111`

## Project structure

    .
    ├── base                    # base application directory, core
    ├── config                  # configs
    ├── controller              # controllers for web
    │    └── base               # base controllers
    ├── view                    # views for web
    ├── model                   # models
    ├── web                     # public directory for web
    ├── vendor                  # composer vendors directory
    ├── samples                 # examples for install project
    │    ├── config             # local config files
    │    └── sql.sql            # DB dump
    ├── bootstrap.php           # main loader file
    ├── composer.json           # composer config
    ├── composer.lock           # composer installed packages config
    ├── .gitignore
    └── README.md

## DB structure

    .
    ├── user                    # users table
    ├── options                 # configurations for lottery
    ├── items                   # items for lottery
    └── winners                 # winners table included user id, type of prize, value/item id
