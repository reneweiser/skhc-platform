# Setup

Make sure you have PHP and Composer installed globally on your machine

```bash
php --version

PHP 8.1.2-1ubuntu2.14 (cli) (built: Aug 18 2023 11:41:11) (NTS)
Copyright (c) The PHP Group
Zend Engine v4.1.2, Copyright (c) Zend Technologies
    with Zend OPcache v8.1.2-1ubuntu2.14, Copyright (c), by Zend Technologies
```
and

```bash
composer --version

Composer version 2.5.4 2023-02-15 13:10:06
```

Make sure Docker is running

```bash
docker --version

Docker version 24.0.6, build ed223bc
```

[Create your sail alias](https://laravel.com/docs/10.x/sail#configuring-a-shell-alias) by adding the following to your bash profile (e.g. .bashrc, .zshrc etc.).

```
alias sail='[ -f sail ] && sh sail || sh vendor/bin/sail'
```

Clone the project
```bash
cd ~/my-projects
git clone https://github.com/reneweiser/skhc-platform.git skhc-platform
[...]
cd skhc-platform
```

Install composer dependencies
```bash
composer install
```

Copy the example environment settings
```bash
cp .env.example .env
```

Change the newly created `.env` file
```diff
+ DB_HOST=mysql
- DB_HOST=127.0.0.1
```

Start docker containers
```bash
sail up -d
```

Generate an app key for the project
```bash
sail artisan key:generate
```

Migrate the database
```bash
sail artisan migrate --seed
```

Install npm dependencies
```bash
sail npm install
```

Run the dev server
```bash
sail npm run dev
```
