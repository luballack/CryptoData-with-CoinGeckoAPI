<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Api description

This api is a result of the Technical Test for Backend Development Team.

It consists on two major endpoint's
- Get a currency data and store into the database: Example "http://localhost/currency/bitcoin".
- Get a currency data, for a specific data, based on the database or on the CoinGeckoAPI: Example "http://localhost/history/bitcoin/2022-09-20".

### 1º Endpoint
'/currency/{id}'

This endpoint first use the CoinGeckoAPI to search for the currency send on the route(id), then, the current price of the coin and its last updated date are stored into the database, and then the full response of the CoinGeckoAPI is returned.
The follow currencys have a table on the database and its data is stored each time the endpoint is acessed:

|  *tag* | *id*  |
|:-:|--:|
| BTC  | bitcoin  |
|  ETH |ethereum|
|  ATOM |cosmos|
|  LUNA |terra-luna-2|
| DACXI  |dacxi|

### 2º Endpoint
'/history/{id}/{date}'

This endpoint first use the database to search for the currency send on the route(id) by the date(date) also passed on the route, then, if the database has the value of the currency at that date, it will make a *average* of the price and will return it. In case of the database do not contains the value stored, it will use a CoinGeckoAPI public endpoint to return the info about that currency, then, if this currency have a table set, the data will be stored.


## Docker Sail

I used a library from laravel to make the container, a series of actions was made to make it possible and i'll list them:

*Tested on Ubuntu 22.04(wsl) and virtualbox Ubuntu machine*

- You have php8.1, composer 2.4.2, docker and docker-compose running on your machine.
- Create a new folder Ex(myapp)
- git clone https://github.com/luballack/CryptoData-with-CoinGeckoAPI.git
- cd CryptoData-with-CoinGeckoAPI/
- cp .env.example .env
- composer require laravel/sail --dev //*note: some extensions may be required if not present*
- php artisan sail:install //*note: choose '0'*
- COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 ./vendor/bin/sail build
- ./vendor/bin/sail up //*note: make sure that ports 80 and 3306 are free*
- sudo chmod 777 -R .env //*note: i had to grant full permissions to the .env and storage to solve a permission issue*
- sudo chmod 777 -R storage
- ./vendor/bin/sail artisan key:generate
- ./vendor/bin/sail artisan migrate --force

## Host/Deployment 

The api was sucessfully hosted on a heroku service.
Acessable via url : (https://cryptodata-by-lucaswfr.herokuapp.com/)


