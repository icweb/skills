# Laravel Skills Tracker
This project allows you to host courses with lessons and lectures. Skills Tracker will also track the date a course has been completed, and offers the ability to set a "re-certification" date.

## Laravel Nova (optional)
This package includes integration with Laravel Nova, however you must purchase your own license, and install the root Nova directory in this project. Laravel Nova integration is optional.

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

Update the ``` .env ``` file to reflect your database connection. Don't forget to create a local database named  ``` skills ```
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

Add the Laravel Tasks Scheduler as a cron job on your local server

```
* * * * * cd /path-to-your-project && php artisan schedule:run >> /dev/null 2>&1
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

Skills uses the TinyMCE WYSIWYG editor. Update the ``` .env ``` file to reflect your TinyMCE API Key
```
TINYMCE_API_KEY=abcdefghijklmnopqrstuvwxyz
```

## Hierarchy
This section covers the basic hierarchy of the Skills tracker to provide a better understanding when just starting out.

A course can contain many lessons, each lesson can contain main lectures, and each lecture can have many skills. A lecture can be either an Article, Quiz, or Download.

```
Course
|-- Lesson
|---- Lecture
|------ Skill

```

An example of a Beginners PHP course would look like this:
```
Beginners PHP
|-- Loops
|---- How to create a For loop
|------ PHP
```

## Courses
A course is the main shell of Skills tracker. 

#### Create Course
1. Click "Add Course" from the "Courses" page.
2. Complete all required fields as explained below.
3. Select the "Save" button to save your changes.

#### Create Course Fields
| Field | Required | Type | Description |
|------------------------------|----------|---------|----------------------------------------------------------------------------------------------------------------|
| Course Title | Yes | Text | The title of the course. |
| URL Slug | Yes | Text | A unique, URL safe string of letters. |
| Recertify Interval (in days) | Yes | Integer | The days a user will have to re-take this course. Enter "0" if you don't want the user to re-take this course. |
| Short Description | Yes | Text | A short description of the course under 250 characters. |
| Long Description | Yes | Text | A long description of the course under 5000 characters. |

## TODO
- Add task to look at receritify dates and add new course_user assignment if needed
- Crossed off lessons should not be displayed is course_user completed_at is null
- Add support for classroom trainings
- Add ability for user to choose if a lesson should be deemed "completed" when all lectures are completed, or selected lectures (i.e. Quiz)
- Add CRUD for Skills

## TODO
- Create foreign keys on database
- Add content to demo data
- Finish README with all CRUD documentation for Skills, Courses, Lessons, and Lectures
- Update screenshots on README
- Comments & Doc Blocks
- Continue to component-ize blade files

## Bugs
- Create Lecture slug not calculating correctly
- Scout shouldBeSearching is being ignoring on App\Lecture
- Delete question on lecture before lecture save results in an error
- Completion History accordian not opening