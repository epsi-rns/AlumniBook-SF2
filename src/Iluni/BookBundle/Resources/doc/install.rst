Install
=======

These guidance below a common installation step for symfony2 project.
Although it looks long. It should be easy for symfony coder.

For more guidance please visit 'symfony installation`_ .

.. _symfony installation: http://symfony.com/doc/2.0/book/installation.html

Apache Configuration
--------------------

-   Configure virtual host on apache.
    Let's say we are going to setup setup http:\\book2 (localhost)
    in /home/yourname/www/book2 directory.

    ::

        # pico /etc/hosts
        # pico /etc/apache2/sites-available/book2

    You can find sample in apache-alumni.txt in this package
    for use in sites-available directory.

    Don't forget to make it available by running a2ensite in terminal.

    ::

        # a2ensite book2
        # apache2ctl restart

    Also don't forget to activate mod rewrite.

    ::

        # a2enmod rewrite
        # service apache2 reload

Project Setup
-------------

-   Download AlumniBook at https://github.com/epsi/AlumniBook-SF2.
    then extract in your project directory.

-   Set-up permission

    ::

        $ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
        $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs

-   Install vendors using composer,
    this might take a couple of minutes.

    ::

        $ php ../composer.phar update

Database
--------

-   Configure database connection,
    mysql is recommended for first use.

    ::

        $ cat app/config/parameters.yml

-   Populate database.

    You can skip this part by creating database manually,
    e.g via phpmyadmin.

    ::

        $ app/console doctrine:database:drop --force
        $ app/console doctrine:database:create

    Load initial sample data (fixtures).

    ::

        $ app/console doctrine:schema:update --force
        $ app/console doctrine:fixtures:load --append
        $ app/console cache:clear --env=dev

    You might need to populate database many times during development process.

-   Set-up assets

    ::

        $ php app/console assets:install web --symlink
        $ php app/console assetic:dump --env=prod

    You might need to dump assets, anytime you change css, or set debug_css to true.

Happy browsing
--------------

-   Browse and login in development environment:
    http://book2/app_dev.php/ .


More on Development
===================

Test
----

If you want, you can do functional test.

    ::

    $ phpunit --debug -c app src/Iluni/BookBundle/Tests/Controller

Coding style
------------

Using PSR standard,
coding style is written to be as close as possible to PSR-[0,1,2].

    ::

    $ cd ~/ ... /CodeSniffer/scripts
    $ php phpcs --config-set default_standard PSR2
    $ php phpcs --extensions=php ~/ ... /book2/src/Iluni/BookBundle

Tools
-----

I'm using these tools during development process

-   LAMP stack on Debian/ Mint

-   Windows: WampServer and Git for windows

-   Client Side: Firebug

-   Text Editor: Geany

-   Image Editor: GIMP

-   MP3 player is useful sometimes. A a cup coffee would be very helpful.


Framework
---------

I'm using PHP + JS.

-   PHP Framework: Symfony2

-   ORM: Doctrine2 (DQL)

-   Templating Engine: Twig

-   Javascript Framework: Mootools 1.3


Other knowledge to consider.

-   PHP itself

-   HTML and CSS Standard. HTML5 and CSS3 is optional.

-   Regular Expression

-   Admin tools: PHPmyAdmin, PgAdmin

-   Web 2.0 Approach: AJAX, REST.
