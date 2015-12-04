AJAIBWEBSITE
============
Repository for Ajaib website and admin panel

## Installation

1. Download [Composer](http://getcomposer.org/doc/00-intro.md) or update `composer self-update`.
2. Run `php composer.phar create-project --prefer-dist laravel/laravel [app_name]`.

If Composer is installed globally, run
```bash
composer create-project --prefer-dist laravel/laravel [app_name]
```

You should now be able to visit the path to where you installed the app and see
the setup traffic lights.

## Configuration

Read and edit `config/app.php` and setup the 'Connection' on `config/database.php` and any other
configuration relevant for your application. And don't forget to update your .env file on root directory


### SET PERMISSION USING ACL

Perform action bellow to grant http user to folders

```bash
$ HTTPDUSER=`ps aux | grep -E '[a]pache|[h]ttpd|[_]www|[w]ww-data|[n]ginx' | grep -v root | head -1 | cut -d\  -f1 | sed -e 's/:/\t/g' | awk '{print $NF}'`

sudo setfacl -R -m u:${HTTPDUSER}:rwx storage
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx storage
sudo setfacl -R -m u:${HTTPDUSER}:rwx bootstrap/cache
sudo setfacl -R -d -m u:${HTTPDUSER}:rwx bootstrap/cache
```

## HOW TO COMMIT - IAMUCIL

Phase 1

1. Fork the project
2. Once it done, clone your forked project
   1. `mkdir project_name`
   2. `cd project_name`
   3. `git init`
   4. Do `git remote add <alias> <URL-git-project>`
3. You've done the initial step (phase 1).

To do phase 2, do the following steps, right before you commit the changes

1. Do `git add .`
2. Do `git commit -am "some message"`
3. Run `git fetch <alias>` (the one you defined in phase 1, step 3)
4. Do `git rebase <alias>/<branch_name>`. The branch name default is usually `master`.
5. Do `git push`

Then do phase 3. Do pull request thru' web interface.

## HOW TO INSTALL AFTER CLONING IN LOCAL

After finishing cloning from github repo into local machine (phase 1, step 3 - 7)

1. Do ``git fetch <alias> <branch_name>``. The branch name default is usually `master`.
2. Do ``git pull <alias> <branch_name>``
3. Do ``composer install``
4. rename ``.env.example`` to ``.env`` on root directory. [More detail](http://laravel.com/docs/5.1/installation#environment-configuration) read the documentation [here](http://laravel.com/docs/5.1/installation#environment-configuration)
5. Set connection database in ``config/database.php``
6. Make sure ``resources`` and ``bootstrap/cache`` are writeable
7. Do ``php artisan key:generate`` to generate key automatically
8. Run your app in your machine