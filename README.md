# Motorcycles

To deploy and run this application, please follow these steps.

- Clone Github repo
```sh
git clone [repo]
```
- cd into project directory.
```sh
cd motorcycles
```
- Run composer to install php dependencies.
```sh
composer install
```
- Run npm to install required node modules.
```sh
npm install
```
- Run npm to compile stylesheets and scripts.
```sh
npm run dev
```
- Copy .env.example file to .env, and set your env values.
- To migrate database, use this command. To seed database use "--seed" option.
```sh
php artisan migrate --seed
```
- To link storage, use this command.
```sh
php artisan storage:link
```
- To run queue worker, use this command.
```sh
php artisan queue:work
```
