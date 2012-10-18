AlumniBook on Symfony
=====================

This is a rewrite of symfony application.
For learning purpose so others may have sample
and speed up their development process.

## Goal

*   Simple questionnaire-based data-entry, rewritten on Symfony2.
*   Learn, share, and get rid of legacy version.

## Support for ILUNI

No support as this project is for learnig purpose only.

But of course for live site, if anyone interested,
can use this source code freely without my permission.


Related Link
------------

This rewrite version:

*   The source code at github
    [AlumniBook on Symfony](https://github.com/epsi/AlumniBook-SF2)
*   <del>Demo site in [book.iluni.org](http://book.iluni.org)</del>
    This site and any preloaded data is only a demonstration of its capability.
    It is not intended for real data entry process.
*   <del>Screenshot at [picasaweb.google.com/epsi.rns](https://picasaweb.google.com/epsi.rns/AlumniBook#)</del>

The original legacy version:

*   [AlumniBook on CodeIgniter](https://github.com/epsi/AlumniBook-CI)
*   [AlumniBook on Delphi](https://github.com/epsi/AlumniBook-D7)
*   [AlumniBook on Symfony](https://github.com/epsi/AlumniBook-SF)

<del>Wiki</del>

*   [Home](https://github.com/epsi/AlumniBook-SF/wiki)
*   [Feature Plan](https://github.com/epsi/AlumniBook-SF/wiki/Feature-Plan)
*   [ILUNI](https://github.com/epsi/AlumniBook-SF/wiki/ILUNI)


Feature
-------

*   Included many good things from Jobeet documentation from
    [Practical Symfony Book](http://www.symfony-project.org/jobeet/1_4/Doctrine/en/).
    I also skipped many other good parts.
    <del>Log of this work in step-by-step.txt.</del>
*   Different layouts: layout, error404, ajax, and modal.
*   Mootools integration:
    * ajax request,
      now we have mootools-symfony-ajax combination (but not integration).
    * form field validation
    * theme effects
    * <del>sfWidgetFormDatePicker</del>
    * dynamic drop down list using ajax (master-detail)
    * Using a special iframe lightbox for value lookup.
      This input also utilize a lookup modal widget.
*   Oriclone Theme:
    My personal theme, the original clone.
    Although I've made it from scratch, it is inspired by other design.
    * CSS compressor (custom assetic filter)
    * Custom 404 error page.
    * <del>Control parameter via app.yml</del>
    * <del>A few source images (XCF's GIMP), only small files.<del>
*   Few plugins: each has their own README.md, most are only mootools wrapper.
*   <del>Also utilize I18n translation in form filter.</del>


<del>Screenshot</del>
----------

*   [Table of contents in multi language](https://picasaweb.google.com/epsi.rns/AlumniBook#5578354736029962338)
*   [Backend for administrator](https://picasaweb.google.com/epsi.rns/AlumniBook#5578354763983509922)
*   [General sheet](https://picasaweb.google.com/epsi.rns/AlumniBook#5578354816024650978)
*   [Alumni detail with AJAX](https://picasaweb.google.com/epsi.rns/AlumniBook#5578355526800334082)
*   [Validation before submit](https://picasaweb.google.com/epsi.rns/AlumniBook#5578360327113373458)
*   [Show with related tabs menu](https://picasaweb.google.com/epsi.rns/AlumniBook#5578355602314296898)
*   [List for master detail table](https://picasaweb.google.com/epsi.rns/AlumniBook#5578355513394329666)
*   [Map relation of person and company](https://picasaweb.google.com/epsi.rns/AlumniBook#5578355686298380562)
*   [Modal box for lookup](https://picasaweb.google.com/epsi.rns/AlumniBook#5578360380680365346)
*   [Custom 404 error page](https://picasaweb.google.com/epsi.rns/AlumniBook#5578356441184900050)
*   [Module item lime test](https://picasaweb.google.com/epsi.rns/AlumniBook#5582497997088174482)
*   [All functional lime test](https://picasaweb.google.com/epsi.rns/AlumniBook#5582498018623503426)

<del>Private Plugins</del>
---------------

Each plugins has its own readmes:

*   [sfThemeOriclonePlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfThemeOriclonePlugin)
*   [sfMootoolsPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMootoolsPlugin)
*   [sfMooDatePickerPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMooDatePickerPlugin)
*   [sfMooDiaBoxPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMooDiaBoxPlugin)
*   [sfMooNoobSlidePlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMooNoobSlidePlugin)
*   [sfMooSideBarMenuPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMooSideBarMenuPlugin)
*   [sfMooTwitterGitterPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfMooTwitterGitterPlugin)
*   [sfFormInputLookupModalPlugin](https://github.com/epsi/AlumniBook-SF/tree/master/plugins/sfFormInputLookupModalPlugin)


Install
-------

These guidance below a common installation step for symfony2 project.
Although it looks long. It should be easy for symfony coder.

For more guidance please visit
[symfony installation](http://symfony.com/doc/2.0/book/installation.html).

### Apache Configuration

*   Configure virtual host on apache.
    Let's say we are going to setup setup http:\\book2 (localhost)
    in /home/yourname/www/book2 directory.

        # pico /etc/hosts
        # pico /etc/apache2/sites-available/book2

    You can find sample in apache-alumni.txt in this package
    for use in sites-available directory.

    Don't forget to make it available by running a2ensite in terminal.

        # a2ensite book2
        # apache2ctl restart

    Also don't forget to activate mod rewrite.

        # a2enmod rewrite
        # service apache2 reload

### Project Setup

*   Download AlumniBook at https://github.com/epsi/AlumniBook-SF2.
    then extract in your project directory.

*   Set-up permission

        $ sudo setfacl -R -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs
        $ sudo setfacl -dR -m u:www-data:rwx -m u:`whoami`:rwx app/cache app/logs

*   Install vendors using composer,
    this might take a couple of minutes.

        $ php ../composer.phar update

### Database

*   Configure database connection,
    mysql is recommended for first use.

        $ cat app/config/parameters.yml

*   Populate database.

    You can skip this part by creating database manually,
    e.g via phpmyadmin.

        $ app/console doctrine:database:drop --force
        $ app/console doctrine:database:create

    Load initial sample data (fixtures).

        $ app/console doctrine:schema:update --force
        $ app/console doctrine:fixtures:load --append
        $ app/console cache:clear --env=dev

    You might need to populate database many times during development process.

*   Set-up assets

        $ php app/console assets:install web --symlink
        $ php app/console assetic:dump --env=prod

    You might need to dump assets, anytime you change css, or set debug_css to true.

### Happy browsing

*   Browse and login in development environment:
    [http://book2/app_dev.php/](http://book2/app_dev.php/).


More on Development
-------------------

### Test

If you want, you can do functional test.

    $ phpunit --debug -c app src/Iluni/BookBundle/Tests/Controller

### Coding style

Using PSR standard,
coding style is written to be as close as possible to PSR-[0,1,2].

    $ cd ~/ ... /CodeSniffer/scripts
    $ php phpcs --config-set default_standard PSR2
    $ php phpcs --extensions=php ~/ ... /book2/src/Iluni/BookBundle

### Tools

I'm using these tools during development process

*   LAMP stack on Debian/ Mint

*   Windows: WampServer and Git for windows

*   Client Side: Firebug

*   Editor: Geany

*   Amusement: mp3 player and many glasses of coffee.

### Framework

I'm using PHP + JS.

*   PHP Framework: Symfony2

*   ORM: Doctrine2

*   Templating Engine: Twig

*   Javascript Framework: Mootools 1.3


License
-------

This work is licensed under
[MIT License](http://www.opensource.org/licenses/mit-license.php).

The Symfony Framework is licensed under MIT License.

Mootools Javascript is licensed under MIT License.

However some works may apply different license,
so I would like to list each to appreciate them.

*   Icons: [Silk Icons](http://www.famfamfam.com/lab/icons/silk/)
    licensed under a Creative Commons Attribution 2.5 License.
*   Images: [OpenClipArt](http://openclipart.org)
    licensed under a CC0 1.0 Universal (CC0 1.0) Public Domain Dedication.
*   [Mootools Javascript Framework](http://mootools.net)
    also licensed under MIT-style license.
*   Mootools-Datepicker by Arian Stolwijk (see sfMooDatePickerPlugin),
    Mootools-NoobSlide by luistar15,
    Mootools-Reflection by Christophe Beyls and
    Mootools-Diabox by Mike Nelson
    licensed under MIT license.
*   Mootools Effects: I also grab many smart sample from
    [David Walsh](http://davidwalsh.name),
    and modify those goodies for use with my oriclone themes.
    It is considered as knowledge for public, not license.
*   The glossy orb logo provided contain Makara logo inside.
    The Makara logo itself belong to University of Indonesia.
    You may preferred to use your own logo.
