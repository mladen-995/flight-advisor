# Flight Advisor

## Requirements
Before you set up project on local environment, please ensure that you have installed the following:
- Docker
- Docker compose

## Installation
In order to set up the project, after you pull it on a local machine, you need to run the following:
1. Copy `.env.example` to `.env`
1. `./vendor/bin/sail up -d` - That will run Docker containers
1. `./vendor/bin/sail artisan composer install`
1. `./vendor/bin/sail artisan migrate --seed`
