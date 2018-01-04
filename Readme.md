# Kookoo.ro #
Kookoo.ro is a whislist site made with symfony 4 and Vue.js

## Prerequisites ##
* php 7.1.3+
* node 8.9.3+
* yarn 1.3.2+
* composer 1.5.5+
* mysql 5.7+

## Install ##
```
composer install
yarn install
```

Install the database:
- create a new database on your local mysql server
- for credentials open `.env` file and change `DATABASE_URL`
- run: `php bin/console doctrine:migrations:migrate`

## Start servers ##
```
yarn start
```
Access http://localhost:4000/