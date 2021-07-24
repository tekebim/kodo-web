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
