# Laravel 8 Simple Loan API

It is a simple loan API that uses Laravel 8.

## How to run

### Manual

-   Clone the repository with git clone.

-   Copy .env.example file to .env and edit database credentials there

-   Composer install

```sh
$ composer install
```

-   Laravel key generate

```sh
$ php artisan key:generate
```

-   Database migrate and seed (it has some seeded data for testing)

```sh
$ php artisan migrate --seed
```

-   Storage link

```sh
$ php artisan storage:link
```

-   Run serve

```sh
$ php artisan serve
```

### Via script

-   Go into root folder

-   Run setup file to setup

```sh
$ sh setup.sh
```

# The api documment

Check latest docs file in ./apidocs folder and change "url" by your host. It was exported from Postman.

# License

Basically, feel free to use and re-use any way you want.

Happy codding!!!
