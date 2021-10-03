Simple worker/consumer test project on Laravel

## SQL file
The sql file is located in `database/worker_example.sql`

# How to run
* run `composer require`
* run `./vendor/bin/sail build` to build the image
* run `./vendor/bin/sail up` to setup and run docker images
* run `./vendor/bin/sail artisan reverify-subscriptions:run`

## How it works
Running `php artisan reverify-subscriptions:run` will check for expired but yet active records, adds them in queue to be checked by its consumer `php artisan rabbitmq:consume subscriptionVerifyConsumer`
