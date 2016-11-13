REA Coding Test
===================

Requirements
-----------
Please refer to [PROBLEM.md](PROBLEM.md)

How to use it
-----------
This is a command-line interactive application. Clone or download the repo to your preferred directory, and then you can run it in either one of the following ways.

#### Docker container
This is preferred, as it does not require you to install any runtime dependencies (except for docker, obviously). You can get up and running simply with the following:

~~~
$ docker build -t rea-robot .
$ docker run -ti rea-robot
~~~

And then you're in.

#### As a local PHP cli app
If you have php-cli 5.6+ installed on your local system, as well as composer installed, you can run the app directly with

~~~
composer install --no-dev
php application.php rea:robot-simulator
~~~