All container configuration is in env file
    1. run `docker-compose up`
    2. enter container (e.g. `sudo docker exec -it ms_chars_chars_php_1 bash`)
    3. Run `php composer.phar update`
    3. Inside container run `php bin/console doctrine:schema:update --force`
    4. Run migrations `php bin/console doctrine:migrations:migrate`
    5. Api documentation here http://localhost:{$PORT_NUMBER_FROM_ENV}/api/v1/doc.json
    6. Test requests for phpStorm inside ~/apiRequest/* directory
