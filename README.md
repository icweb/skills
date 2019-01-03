# Laravel Skills Tracker
This package allows you to host courses with lessons and lectures.

## Laravel Nova
This package includes integration with Laravel Nova, however you must purchase your own license, and install the root Nova directory in this project.

![alt text](https://raw.githubusercontent.com/icweb/skills/master/public/github_1.png)

![alt text](https://raw.githubusercontent.com/icweb/skills/master/public/github_2.png)

## Installation
Clone the project (or download it from GitHub)
```
git clone https://github.com/icweb/skills
```

Change into the project directory 
```
cd skills
```

Install the dependencies
```
composer install
```

Create an application environment file
```
mv .env.example .env
```

Generate the application key
```
php artisan key:generate
```

Update the .ENV file to reflect your database connection
```
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=skills
DB_USERNAME=root
DB_PASSWORD=root
DB_SOCKET=/Applications/MAMP/tmp/mysql/mysql.sock
```

Run the migrations and (optionally) seed the database with demo data
```
php artisan migrate --seed
```

Set directory permissions
```
sudo chmod -R 777 bootstrap
sudo chmod -R 777 storage
```

If you choose to seed the database, you can log into the application with the following credentials
```
Username: admin@admin.com
Password: secret
```
