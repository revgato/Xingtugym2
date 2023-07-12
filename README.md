# How to run the code
## Local

```sh
git clone https://github.com/revgato/Xingtugym2.git
cd Xingtugym2
cp .env.example .env
composer install
php artisan key:generate
php artisan migrate:fresh
php artisan db:seed --force
php artisan serve
```

## Docker

```sh
git clone https://github.com/revgato/Xingtugym2.git
cd Xingtugym2
cp .env.example .env

./install-docker.sh
./script.sh build

./script.sh start
```