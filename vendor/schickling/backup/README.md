laravel-backup [![Build Status](https://travis-ci.org/schickling/laravel-backup.png)](https://travis-ci.org/schickling/laravel-backup) [![Coverage Status](https://coveralls.io/repos/schickling/laravel-backup/badge.png?branch=master)](https://coveralls.io/r/schickling/laravel-backup?branch=master) [![Total Downloads](https://poser.pugx.org/schickling/backup/downloads.png)](https://packagist.org/packages/schickling/backup)
==============

Backup and restore database support for Laravel 4 applications

## Installation

1. Add the following to your composer.json and run `composer update`

    ```json
    {
        "require": {
            "schickling/backup": "dev-master"
        }
    }
    ```

2. Add `Schickling\Backup\BackupServiceProvider` to your config/app.php

## Usage

#### Backup
Creates a dump file in `app/storage/dumps`
```
php artisan db:backup
```

###### Upload to AWS S3
```
php artisan db:backup --upload-s3 your-bucket
```
Uses the [aws/aws-sdk-php-laravel](https://github.com/aws/aws-sdk-php-laravel) package which needs to be [configured](https://github.com/aws/aws-sdk-php-laravel#configuration).

#### Restore
Paths are relative to the app/storage/dumps folder.

###### Restore a dump
```
php artisan db:restore dump.sql
```

###### List dumps
```
php artisan db:restore
```

## Configuration
You can configure the package by adding a `backup` section in your `app/config/database.php`.

__All settings are optional and have default values.__
```php
    // ...

    'default' => 'mysql',

    /*
    |--------------------------------------------------------------------------
    | Backup settings
    |--------------------------------------------------------------------------
    |
    */
    'backup' => array(
    	// add a backup folder in the app/database/ or your dump folder
        'path'  => app_path().'/database/backup/',
        // add the path to the restore and backup command of mysql
        // this exemple is if your are using MAMP server on a mac
        'mysql' => array(
    			'dump_command_path' => '/Applications/MAMP/Library/bin/',
    			'restore_command_path' => '/Applications/MAMP/Library/bin/',
    		),
        // s3 settings
        's3'    => array(
            'path'  => 'your/s3/dump/folder'
            )
    ),
    
    // ...
```

## Dependencies

#### ...for MySQL
You need to have `mysqldump` installed. It's usually already installed with MySQL itself.

## TODO - Upcoming Features
* `db:restore WRONGFILENAME` more detailed error message
* `db:backup FILENAME` set title for dump
* `db:backup --db CONNECTION` specify connection, default: default connection
* Compress dump files
* S3
 * Upload as default
 * default bucket
* More detailed folder checking (permission, existence, ...)
* *Some more ideas? Tell me!*


[![Bitdeli Badge](https://d2weczhvl823v0.cloudfront.net/schickling/laravel-backup/trend.png)](https://bitdeli.com/free "Bitdeli Badge")

