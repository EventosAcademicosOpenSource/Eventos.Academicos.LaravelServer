# Eventos.Academicos.LaravelServer

Servidor Laravel PHP para cadastro de eventos acadêmicos. Ele foi desenvolvido para ser consumido por [este](https://github.com/EventosAcademicosOpenSource/Eventos.Academicos.Ionic) aplicativo mobile cliente. 

<img src="https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen1.png" width="600" /><img src="https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen2.png" width="600" /><img src="https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen3.png" width="600" /><img src="https://raw.githubusercontent.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/master/public/images/project/screen4.png" width="600" />



## Funcionalidades: 

- Cadastrar Patrocinador - cadastro de um ou mais patrocinadores para serem vinculado a um ou mais eventos.

- Cadastrar Palestrante - cadastrar palestrantes para poder vincular em uma ou mais palestras.

- Cadastrar Evento - ao cadastrar um evento pode selecionar patrocinadores e criar notificações para o evento. Outra funcionalidade que o sistema disponibiliza é a possibilidade de cadastrar um evento integrante (quando necessário) e também palestras.

- Cadastrar Evento Integrante - é possivél cadastrar múltiplos evento integrante ao evento. Eventos integrantes, são eventos cadastrados sem um palestrante, como por exemplo uma mostra de quadros, haapy hour, etc.

- Cadastrar Palestra - O cadastro da palestra é obrigatório vincular um palestrante, aqui você constroi a agenda do evento.

- Cadastrar notificação - No menu ações na lista de eventos é possível criar uma notificação para quem favoritar previamente o evento, somente usuários que favoritaram o evento no aplicativo receberam essa notificação. Os que não receberem poderam ter acesso na dashboard do evento no aplicativo, no icone das mensagens.

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
- Se não desejar utilizar a s3 para armazenar as imagens tem que reconfigurar os arquivos que fazem os uploads de capas.

## Acesso padrão

A senha e login padrão encontra-se [AdministratorSeed.php](https://github.com/EventosAcademicosOpenSource/Eventos.Academicos.LaravelServer/blob/ed7147a332d1fe665327539addc4c67635371d5e/database/seeds/AdministratorSeed.php#L1)
