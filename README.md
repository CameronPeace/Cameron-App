## Cameron App
A laravel based application displaying various projects and features.

## Spinning Up
(These steps are outdated but still work and will be updated soon)
To setup locally please follow the steps below. You will need docker installed and running.
These steps should be followed in your desired terminal.
1. In the root of the project directory, copy the contents of the `.env.example` file and populate the `DB_USERNAME` and `DB_PASSWORD` values with your desired local db credentials. AS well as the `OPEN_AI_API_SECRET` key.
    - if you do not have an OpenAI API account import files should be provided for all the needed tables.
2. In your terminal run `composer install` while at the root of the project directory
3. Then, run `php artisan key:generate` to generate an app key.
4. Then, run `docker-compose up --build -d` and wait for it to complete.
    - Docker will prepare the containers and the local mysql database.
5. Now `php artisan migrate` to migrate our tables into our local database.
6. This project uses OpenAI to seed the database with dynamic data. If you have provided an `OPEN_AI_API_SECRET` key to your `.env` you can run `php artisan db:seed` in your terminal. Do not worry if things take a moment to finish.
    - If you are not using OPENAI, manually import the included csv files OR run the sql inserts, comment out lines 18 and 19 in /database/seeders/TheaterDataSeeder.php then run `php artisan db:seed` to run the remaining factory seeders.
    - The required csv files to import can be found at `/database/seeders/theater/manual/csv` and the direct inserts are located at `/database/seeders/theater/manual/inserts`
    - Your database should now have several populated tables and a stored procedure.
7. run `php artisan jwt:secret` to generate a secret key for our internal api. You will need this key later so keep it on hand.
8. Navigate back to your `.env` and change the `DB_HOST` to the name of the mysql docker container. You need to do this to run the application.
    - For this example my container is named `cameron-app_database_1`
    - To run migrations and seeders again the `DB_HOST` will need to be reset back to 127.0.0.1 and vice versa.
9. At this point ensure the API docker image has been spun up as well.
    - The steps for that [Can be found here](https://github.com/CameronPeace/Cameron-App-Api)
10. run `npm install && npm run dev` and navigate to localhost in your browser of choice
11. To get to the dashboard register an email and password to login. You can use the combination to back in later as long as your local database maintains its data.


## Cameron App API

This application pulls data from an interal API. This API must also be built and ready for the application to function.

[The Api repository can be found here](https://github.com/CameronPeace/Cameron-App-Api)
