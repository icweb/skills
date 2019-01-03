# Laravel Skills Tracker
This project allows you to host courses with lessons and lectures. Skills Tracker will also track the date a course has been completed, and offers the ability to set a "re-certification" date.

## Laravel Nova (optional)
This package includes integration with Laravel Nova, however you must purchase your own license, and install the root Nova directory in this project.

## Screenshots
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

Update the .ENV file to reflect your database connection. Be sure to create a local database named  ``` skills ```
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

If you chose to seed the database, you can log into the application with the following credentials
```
Username: admin@admin.com
Password: secret
```

## TODO
- Add ability to add course content
- Move skills to a lecture level instead of a lesson level - Then the charts can be based on time
- Continue to component-ize blade files
- Add ability to delete course
- Add field tooltips describing what should be entered
- Add WYSIWYG editors
- Add character limits to UI on body fields
- Add validation for slug fields
- Add checkbox field to 'Create Course form' to import sample lessons (Will need to adjust database to mark lessons and lectures and samples)