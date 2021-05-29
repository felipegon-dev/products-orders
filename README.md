# Installation steps

```
* docker-compose -f YOUR_PATH/softonic-api/deploy/docker-compose.yml up -d

* Enter in you docker container (api_rest_php) with bash and execute:
cd /usr/local/apache2/htdocs/api-rest
composer install
php bin/console --no-interaction doctrine:migrations:migrate 
```

# Endpoints

POST http://localhost:8082/product
```
Payload:
{
    "name": "test",
    "price": 23.1
}
Response:
{
    "status": 200,
    "response": {
        "id": 7,
        "name": "test",
        "price": 23.1
    }
}
```

POST http://localhost:8082/order
```
{
    "status": 200,
    "response": {
        "id": 3,
        "totalPrice": 0
    }
}
```

POST http://localhost:8082/order/product/add
```
{
    "status": 200,
    "response": {
        "order": {
            "id": 3,
            "totalPrice": 23
        },
        "products": [
            {
                "id": 7,
                "quantity": 1
            }
        ]
    }
}
```

GET http://localhost:8082/order/{orderID}
```
{
    "status": 200,
    "response": {
        "order": {
            "id": 3,
            "totalPrice": 23
        },
        "products": [
            {
                "id": 7,
                "quantity": 1
            }
        ]
    }
}
```

### Quality code tools installed
* phpmd/phpmd all basic rules, except naming rule ($id)
* squizlabs/php_codesniffer with PSR2

### Tests
```
./vendor/codeception/codeception/codecept run tests/unit
``` 

### Documentation:

http://localhost:8082/api/doc
 



