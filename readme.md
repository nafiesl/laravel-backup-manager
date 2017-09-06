# Laravel Database Backup and Restore

This is a database **backup** and **restore** feature for Laravel 5.3. It uses [backup-manager/laravel](https://github.com/backup-manager/laravel).

![Laravel Backup Manager](public/imgs/screenshot.jpg)

## Features
In this Laravel application, we will get this features:

1. Create new Backup File
2. See Backup Files list
3. Delete existing backup file
4. Restore database from a backup file
5. Download backup file
6. Upload a backup file

## How to use

1. Open terminal
2. Clone this repo and cd into project folder
3. `composer install`
4. Set your database credentials to `.env` file
5. Set proper permission your `storage` folder
6. `php artisan key:generate`
7. `php artisan migrate`
8. Open application in browser
9. Register new Account
10. Navigate to `Database Backup Manager` menu

## License

The Laravel framework is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT).
