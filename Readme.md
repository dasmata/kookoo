# Kookoo.ro #
Kookoo.ro is a whislist site made with symfony 4 and Vue.js
## Prerequisites ##
* php 7.1+
* node 8.9.3+
* yarn 1.3.2+
* composer 1.5.5+
* mysql 5.7+
## Install ##
```
composer install
yarn install
```
## Start servers ##
```
sud php bin/console server:start *:80 &
yarn run encore dev-server --watch --host 0.0.0.0 --public localhost:8080 &
```
