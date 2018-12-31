# Laravel Skills Tracker
This package allows you to host courses with lessons and lectures.

## Laravel Nova
This package includes integration with Laravel Nova, however you must purchase your own license, and install the root Nova directory in this project.

![alt text](https://raw.githubusercontent.com/icweb/skills/master/public/github_1.png)

![alt text](https://raw.githubusercontent.com/icweb/skills/master/public/github_2.png)

## Installation
Download the project
```
git clone https://github.com/icweb/skills
```

Change into the project directory and install the dependencies
```
composer install
```

Create an application environment file
```
mv .env.example .env
```

Run the migrations and (optionally) seed the database with demo data
```
php artisan migrate --seed
```