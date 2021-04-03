# Flight Advisor

## Requirements
Before you set up project on local environment, please ensure that you have installed the following:
- Docker
- Docker compose

## Installation
In order to set up the project, after you pull it on a local machine, you need to run the following:
1. Copy `.env.example` to `.env`
1. `./vendor/bin/sail artisan composer install`
1. `./vendor/bin/sail up -d` - It will run Docker containers
1. `./vendor/bin/sail artisan migrate --seed`

## Troubleshooting
Ports for web server and MySQL are changed, so it doesn't have conflicts with the instances on local machine.
If you want to connect to MySQL database, you can use credentials from `.env`, but for the port please use value from `FORWARD_DB_PORT` inside `.env`.

When you send requestes, please add header `Accept: application/json`.

## Initial users
After you perform installation steps, you will see two users in the database which you can use right away.

ADMIN:  
Username: `mladen`  
Password: `password`

REGULAR USER:  
Username: `korisnik`  
Password: `password`  

## Import of airports and routes
After you create few cities, you can import airports and routes for those cities.

In order to do that, please run the following in the exact order:
1. `./vendor/bin/sail artisan import-airports`
1. `./vendor/bin/sail artisan import-routes`

## Running unit tests
In order to execute tests, you need to run `./vendor/bin/sail test`

## Where are endpoints located?
To see a list of all available endpoints that application is able to serve, you can check `routes/api/php`.
