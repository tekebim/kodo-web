# Symfony Web Application with Docker

> Using MYSQL / PHP / PhpMyAdmin

- Editable `.env` configuration file

### Access PHP container to initialize symfony
`docker-compose exec php /bin/bash`

### Check symfony requirements
`symfony check:requirements`


### Create the new symfony app
`symfony new .`

### Install libs
```
composer req --dev maker ormfixtures fakerphp/faker
composer req doctrine twig
```

### Check MYSQL connection
```
docker compose exec database mysql -uroot -p

#mysql > show databases;
```


### Install Webpack assets config
```
docker compose exec php /bin/bash
cd kodo
composer require symfony/webpack-encore-bundle
yarn install
```
#### Enable .enableSassLoader()

> Uncomment `.enableSassLoader()` on `webpack.config.js`

#### Then install missing yarn lib (for sass)
```
yarn add sass-loader@^12.0.0 sass --dev
```
#### Execute encore asset building
```
yarn run encore production
yarn run encore dev --watch

yarn add postcss-loader autoprefixer --dev
yarn add bootstrap@next
```

#### Execute symfony console command
```
symfony console make:entity Establishment
symfony console make:controller EstablishmentController
symfony console doctrine:schema:update -f
```

#### ORM Doctrine remove field from Entity
```
symfony console doctrine:migrations:diff
symfony console doctrine:migrations:migrate
```

#### load fixtures
```
symfony console doctrine:fixtures:load
```
