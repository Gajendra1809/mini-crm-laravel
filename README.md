##About miniCRM and how to set up the project...

MiniCRM is desktop web application which can used for managing the companies and their employees data all together
Admin can perform operations like Create, Read, Update and Delete operations on two categories i.e. Companies and Employees
The plateform is developed with proper validations

#Project set-up
1. Download or clone the project in your local machine

2. Set database credentials in .env file

3. Run command to migrate Database
   php artisan migrate

4. Run db seed to create admin user with email- admin@admin.com and password- password
   php artisan db:seed

5. Run queue:work to run the queueable jobs
   php artisan queue:work

6. Finally start the project with this command
   php artisan serve

7. To login use
   email- admin@admin.com
   password- password
