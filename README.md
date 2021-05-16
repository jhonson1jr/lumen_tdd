# Projeto APIs com Lumen Framework e TDD com PHPUnit

## Conhecimentos necessários:
PHP, Laravel, Orientação a Objeto, SQL

## Tecnologias:

Composer, MySQL, Php 7, Lumen

## Instruções

Baixar o projeto;

Executar dentro do prompt de comando dentro do diretório raiz do projeto:
```
composer update
```


Criar uma base de dados no MySQL e criar um arquivo .env seguindo o .env.example, alterando os dados de conexao à base e de e-mail

```php
DB_CONNECTION=mysql
DB_HOST=<seu host>
DB_PORT=3306
DB_DATABASE=<sua database>
DB_USERNAME=<seu usuário>
DB_PASSWORD=<sua senha>
```

Abrir console dentro do diretório raiz da aplicação e executar as Migrations:
```
./artisan migrate
```


Criando um atalho para a execução do comando phpunit que processa os testes -> abrir console dentro do diretório raiz da aplicação e executar:
```
alias testar='vendor/phpunit/phpunit/phpunit'
```
No arquivo bootstrap/app.php, se necessário, descomentar a linha 26 e 28:
```
$app->withFacades();
$app->withEloquent();
```

Para acessar as rotas pelo navegador, executar no prompt de comando dentro do diretório raiz, substituindo NUMERO_DA_PORTA por exemplo por 8001:
```
php -S localhost:NUMERO_DA_PORTA
```

Caso seja necessário gerar chave para o projeto, com o projeto em execução, acessar a rota abaixo e colocar o resultado dentro do arquivo .env:
```
http://localhost:NUMERO_DA_PORTA/gerarchave
```
