All container configuration is in env file

    1. run `docker-compose up`
    
    2. enter container (e.g. `sudo docker exec -it ms_chars_chars_php_1 bash`)
    
    3. run `php composer.phar update` inside container
    
    3. run `php bin/console doctrine:schema:update --force` Inside container 
    
    4. Run migrations `php bin/console doctrine:migrations:migrate`
    
    5. Api documentation here http://localhost:{$PORT_NUMBER_FROM_ENV}/api/v1/doc.json
    
    6. Test requests for phpStorm inside ~/apiRequest/* directory
    
    
@TODO
    
    1. все api не является идемпотентным    
