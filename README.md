
# Projeto para avaliação técnica "contact manager"

O projeto contempla uma API laravel para cadastro de usuário, seus contatos com endereço e integração com as VIACep, Google GeoCoding e Google Maps Static

## Tecnologias Utilizadas:

- Ambiente docker com PHP 8.2, MySQL 8.0, phpMyAdmin e Nginx
- Laravel 11 
- JWT (para autenticação)
- Swagger

Técnicas Utilizadas:

- Conceitos SOLID
- Código Limpo
- Injeção de dependências
- PSR7

## Deploy

Para inicar o projeto, basta rodar os comandos abaixo em um ambiente com docker instalado:

```bash
  cp contact-app/.env.example contact-app/.env
  docker compose build
  docker compose up -d
  docker exec php-server composer install
  docker exec php-server php artisan config:cache
  docker exec php-server php artisan migrate
```

O endereço padrão é http://localhost:8080/

## Documentação da API

A Documentação está disponivel no endpoint http://localhost:8080/api/documentation
