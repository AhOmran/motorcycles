# Motorcycles

To deploy and run this application, please follow these steps.

- Clone Github repo
```sh
composer clone [repo]
```
- cd into project directory.
```sh
cd motorcycles
```
- Run composer to install php dependencies.
```sh
composer installl
```
- Run npm to install required node modules.
```sh
npm installl
```
- Run npm run [env] to compile stylesheets and scripts.
```sh
npm run dev
```
- To migrate database, use php artisan migrate. To seed database use "--seed" option.
```sh
php artisan migrate --seed
```
- To queue worker, use php artisan queue:work.
```sh
php artisan queue:work
```
