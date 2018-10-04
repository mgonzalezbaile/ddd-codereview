# Code Review
This repo contains the code examples explained in my post series:

1. [Implementing a use case (I) - Intro](https://medium.com/@mgonzalezbaile/implementing-a-use-case-i-intro-38c80b4fed0)
2. [Implementing a use case (II) - Command Pattern](https://medium.com/@mgonzalezbaile/implementing-a-use-case-ii-command-pattern-2d49d980e61c)
3. [Implementing a use case (III) - Command Bus](https://medium.com/@mgonzalezbaile/implementing-a-use-case-iii-command-bus-9bff58766d28)
4. [Implementing a use case (IV) — Domain Events (I)](https://medium.com/@mgonzalezbaile/implementing-a-use-case-v-domain-events-i-21549bb87281)
5. [Implementing a use case (IV) — Domain Events (II)](https://medium.com/@mgonzalezbaile/implementing-a-use-case-v-domain-events-ii-22164128ed0f)
6. To be continued...

If you want to execute the tests:
1. Build the docker image:
```
docker-compose --file docker/compose.yaml --project-name codereview build
```
2. Install dependencies:
```
docker-compose --file docker/compose.yaml --project-name codereview run --no-deps --rm --user ${UID} codereview php composer.phar install
```
3. Run tests
```
docker-compose --file docker/compose.yaml --project-name codereview run --no-deps --rm --user ${UID} codereview php /srv/app/vendor/phpunit/phpunit/phpunit
```
