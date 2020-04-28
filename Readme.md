##Installation
For starting project and running docker just run this command from project root <br/>`./start.sh`
After docker and composer finish processing the api is ready

Symfony: http://localhost:8000 <br/>
Adminer: http://localhost:8080 (server:mysql user:root password:dbrootpw)<br/>
RabbitMq: http://localhost:15672 (user:user password:password) <br/>

Link for postman collection - https://www.getpostman.com/collections/087a1134f1efc7bbb316<br/>Need import in postman.

##How to create row in Google Sheet
```
docker-compose run --rm php-fpm bash
php bin/console messenger:consume -vv
```

Before using of post order api endpoint('Create customer order') we need to run symfony consumer from php container <br/>

Then you will see logs in terminal 
```
2020-04-28T12:25:49+00:00 [info] Received message App\Message\OrderMessage
2020-04-28T12:25:51+00:00 [info] Message App\Message\OrderMessage handled by App\MessageHandler\GoogleSpreadSheetHandler::__invoke
2020-04-28T12:25:51+00:00 [info] App\Message\OrderMessage was handled successfully (acknowledging to transport).
```
And new row in spreadsheat will appear <br/>
Acces by link to spreadheet : https://docs.google.com/spreadsheets/d/1_0jESKknpOivlKpsinVfLlQu0jPmqIMcVjp3T4mrFwo/edit?usp=sharing

If something goes wrong please contact me by email)
