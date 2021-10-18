#!/bin/bash
echo "[x] Make sure that you copy .env.example file to .env file and edit database credetials there first \n"
sleep 2;
echo "[x] Step 1: Composer install \n"
composer install
sleep 2;

echo "\n[x] Step 2: Generate key \n"
php artisan key:generate
sleep 2;

echo "\n[x] Step 3: Migrate & Seed - It has some seeded for testing \n"
php artisan migrate --seed
sleep 2;

echo "\n[x] Step 4: Storage link \n"
php artisan storage:link
sleep 2;

echo "\n[x] Step 4 (optional): Run server. You can use your webser instead of \n"
php artisan serve