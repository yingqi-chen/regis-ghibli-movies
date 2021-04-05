# Ghibli Wiki

Ghibli Wiki is a fan website for studio Ghibli. To help people share their interest and love for the work of studio Ghibli, it enables a user to add movie and attach character, stories and directors to it. Therefore, a user can contribute to this website too instead of just browsing it passively.

# Configuration instructions
## Configure _AMP Stack
This application can be easilty configured to your local or remote development environment on top of an already existing LAMP, WAMP, XAMP, or similarly appropriate _AMP stack. You will need to have a MySQL server installed with a user and sudo privileges.

## Configure webroot directory
You will also need a webroot directory created which will be where the installation files will reside. In the example used here, the directory was /var/www/.

# Installation instructions

## Create Application Directory
- Create an application directory where you will next copy project files into (e.g., /var/www/project1)
## Copy files to webroot directory
In the application package there are seven files that need to be copied over to the application directory you created in earlier step.

## Database Installation
- create MySQL Database called 'ghibli_movies'
- go to `localhost/seed.php`, that will set up the tables and some data for you

## db.php

- `db.php` is where you can modify database name, user name and login. 

# Operating instructions
- Now go to localhost in your browser, and you should see all the movies in the database displayed.
- You can click the button to create a movie that you want. After the creation, you will be redirected or you can go to `index.php` to see the all the movies in the database to see your own movie.
- You can click the update/delete button under each movie to make the corresponding operations.


