# Eventos.Academicos.LaravelServer

Servidor Laravel PHP para cadastro de eventos acadêmicos.

![](https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen1.png| width=300)
![](https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen2.png| width=300)



## Requisitos

- [Git](http://git-scm.com/book/en/v2/Getting-Started-Installing-Git)
- [Laravel](https://laravel.com/docs/5.7/installation#server-requirements)

## Instalação

```sh
git clone https://github.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer.git
cd Eventos.Academicos.LaravelServer
composer install
cp .env.example .env
php artisan key:generate
php artisan serve
```

## Configurações necessárias

- Banco de dados heroku, no arquivo .env configurar:

  ```sh
  CLEARDB_DATABASE_URL=
  ```

- Rodar o comando no terminal
  `php artisan migrate --seed`

- Firebase, no arquivo .env configurar:
  `FCM_SERVER_KEY=`

- Configurar s3 que é utilizado para guardar as imagens, modificar o .env:

  ```sh
  AWS_ACCESS_KEY_ID=
  AWS_BUCKET=
  AWS_DEFAULT_REGION=
  AWS_SECRET_ACCESS_KEY=
  ```

## Acesso padrão

A senha e login padrão encontra-se [AdministratorSeed.php](https://github.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/blob/ed7147a332d1fe665327539addc4c67635371d5e/database/seeds/AdministratorSeed.php#L1)
