# Processo seletivo - Desenvolvedor PHP Sênior

### DOCUMENTAÇÃO

- [Para iniciar](#para-iniciar-o-serviço)
- [Plataforma para execução do projeto](#plataforma-para-execução-do-projeto)
- [Linguagens utilizadas no desenvolvimento](#linguagem)
- [Instalação](#Instalação)
- [Banco de dados](#banco-de-dados)
- [Observações](#observações)

## Para iniciar o serviço 
Essas instruções farão com que você tenha uma cópia do projeto em execução na sua máquina local para fins de desenvolvimento e teste. Veja a implantação de notas sobre como implantar o projeto em um sistema ativo.

## Plataforma para execução do projeto

```Browser
Browser 
Ferramenta cliente de API REST (Postman ou Insomnia)
```

## Linguagem

```php
PHP 8.2.1
Laravel 10.8.0
JavaScript
CSS

bibliotecas
jQuery
Bootstrap
```

## Instalação

```Clonar o projeto em 
https://github.com/marisvaldo1/registro_usuarios.git

pelo terminal executar 
    - composer install
    - criar o banco de dados manualmente
rodar as migrations para a criação das tabelas 
    - php artisan migrate
Iniciar o servidor 
    - php artisan serve

Para executar o projeto web entrar no link
- http://localhost:8000/

Para efetuar os testes
- php artisan test

Para executar a API pelo insomnia
- chamar o endereço localhost:8000/api/usuarios com o método POST
  colocando os dados como json e passando por exemplo os valores abaixo

  {
    "name": "Marisvaldo G",
    "email": "marisvaldo@gmail.com",
    "password": "123456",
    "password_confirmation": "123456"
}

```

## Banco de dados
</br>Tipo de servidor: PostgreSQL
As configurações do banco de dados estão no arquivo .env abaixo
<br>

```.env
DB_CONNECTION=pgsql
DB_HOST=127.0.0.1
DB_PORT=5432
DB_DATABASE=FirstDecision
DB_USERNAME=usuario
DB_PASSWORD=senha
```