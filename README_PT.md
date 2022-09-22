<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>


## Descrição da Api

Esta API é resultado do Teste Técnico para a Equipe de Desenvolvimento de Backend Dacxi.

Consiste em dois endpoints principais
- Obtenha dados de moeda e armazene no banco de dados: Exemplo: "http://localhost/currency/bitcoin".
- Obtenha os dados de uma moeda, para uma data específica, com base no banco de dados ou na CoinGeckoAPI: Exemplo "http://localhost/history/bitcoin/2022-09-20".

### 1º Endpoint
'/currency/{id}'

Esse endpoint primeiro usa a CoinGeckoAPI para procurar a moeda enviada na rota(id), então, o preço atual da moeda e sua última data de atualização são armazenados no banco de dados e, em seguida, a resposta completa da CoinGeckoAPI é retornada.
As seguintes moedas possuem uma tabela no banco de dados e seus dados são armazenados cada vez que esse endpoint é acessado:

|  *tag* | *id*  |
|:-:|--:|
| BTC  | bitcoin  |
|  ETH |ethereum|
|  ATOM |cosmos|
|  LUNA |terra-luna-2|
| DACXI  |dacxi|

### 2º Endpoint
'/history/{id}/{date}'

Este endpoint primeiro usa o banco de dados para pesquisar a moeda enviada na rota(id) pela data(data) também passada na rota, então, se o banco de dados tiver o valor da moeda naquela data, ele fará um * média* do preço e a devolverá. Caso o banco de dados não contenha o valor armazenado, ele usará um endpoint público CoinGeckoAPI para retornar as informações sobre essa moeda, então, se essa moeda tiver uma tabela definida, os dados serão armazenados.


## Docker Sail

Usei uma biblioteca do laravel para fazer o container, foi feita uma série de ações para que isso fosse possível que foram as seguintes:

*Tested on Ubuntu 22.04(wsl) and virtualbox Ubuntu machine*

- You have php8.1, composer 2.4.2, docker and docker-compose running on your machine.
- Cria um diretório Ex(/myapp/)
- git clone https://github.com/luballack/CryptoData-with-CoinGeckoAPI.git
- cd CryptoData-with-CoinGeckoAPI/
- cp .env.example .env
- composer require laravel/sail --dev //*nota: algumas extensões podem ser necessárias se não estiverem presentes*
- php artisan sail:install //*nota: escolha '0'*
- COMPOSE_DOCKER_CLI_BUILD=1 DOCKER_BUILDKIT=1 ./vendor/bin/sail build
- ./vendor/bin/sail up //*nota: verifique se as portas 80 e 3306 estão livres*
- sudo chmod 777 -R .env //*nota:eu tive que conceder permissões totais ao .env e /storage/ para resolver um problema de permissãoe*
- sudo chmod 777 -R storage
- ./vendor/bin/sail artisan key:generate
- ./vendor/bin/sail artisan migrate --force

## Host/Deployment 

A API foi hospedada com sucesso em um serviço heroku.

Acessível por url: (https://cryptodata-by-lucaswfr.herokuapp.com/)


