How do I learn
--------------

This section explain this project step-by-step.
I'm learning SF2 by doing. And this project is the result.

For more comprehensive material,
there are many good tutorial that you can read in internet.
Reading official symfony documentation is a must.


### Controller and View

The very basic is a page that is not using any entity e.g. about page.

*   Action

    This page require routing.yml that
    will match url request to DefaultController.php.

        ../Controller/DefaultController.php

    In this DefaultController class there is an aboutAction() method
    tha call a template, about.html.twig.

*   Twig Template

        ../Resources/views/Modules/Default/about.html.twig

    It is using twig inheritance, in this case is standard layout.

*   Browser

        http://book2/app_dev.php/about


### Model

Suppose a noob want to create a new bundle,
or maybe just have a look at an already exist entity.
Let's say the alumni entity as example.

*   Doctrine2 mapping

        ../Resources/config/doctrine/Alumni.orm.yml

    After create mapping from E-R diagram you would make a php class

        $ app/console doctrine:generate:entities --no-backup IluniBookBundle

*   Entity Class

        ../Entity/Alumni.php

    You can add any necessary method or modify to suit your needs.

        $ app/console doctrine:schema:update --force

*   Data Fixtures

    In most cases, you need sample data,
    especially in development process or testing.
    Let's have a look:

        ../DataFitures/Fixtures/100_alumni.yml

    Nevermind the number, it is just an order of which fixtures executed.
    This yaml itself is just a data that needed to be interpreted by a class.

        ../DataFitures/ORM/LoadAlumniData.php

    You need fixtures bundle to run data fixtures

        vendor/doctrine/data-fixtures
        vendor/doctrine/data-fixtures-bundle

    Let's run it from console

        $ app/console doctrine:fixtures:load --append


*   CRUD Generator

    After this step you might want to create crud.

        $ php app/console doctrine:generate:crud \
        --entity=IluniBookBundle:Alumni \
        --route-prefix=alumni --with-write --format=yml

    But let us imagine that we do it manually
    because we want to split controller into CRUD and Filter.


### CRUD Controller

This the controller to manipulate data entry.

*   Routing

    Again, first we need to setup routing:

        ../Resources/config/routing/crud/alumni.yml

*   Controller

        ../Controller/CRUD/AlumniController.php

    This controller has many action:
    index (r)ead, (c)reate, (u)pdate, new, edit and (d)elete.

    Which most of the action using the same form.

*   Form

        ../Form/Entity/AlumniForm.php

    Each field in this form might use a constraint.

        ../Resources/config/validation.yml

*   Twig

    Since this controller has many action, it needs many twig files.

        ../Resources/views/Master/Alumni/show.html.twig
        ../Resources/views/Master/Alumni/form.html.twig

*   Browser

        http://book2/app_dev.php/alumni/1/show

*   Test

        Tests/Controller/CRUD/AlumniControllerTest.php


### Filter Controller

This is the data viewer
featured by some kind of search from to narrow record result.
To limit data viewed, we are using pagination.

*   Routing

    As usual:

        ../Resources/config/routing/filter/alumni.yml

*   Controller

        ../Controller/Filter/AlumniController.php

    This controller only one action: index.
    But each call two other action filter form and table result.

    Both could placed directly on page,
    or could be embedded using AJAX.

*   Filter Form

        ../Form/Filter/AlumniForm.php

    Some field in this form might use a reusable custom field
    e.g. ordering.

        ../Form/Type/OrderByType.php

*   Repository

    Table result usually need custom sql/dql query.
    Since we want to separate Entity from the ORM,
    We need special class called repository to handle queries.

        ../Repository/AlumniRepository.php

    One Entity can only have one repository.
    It is defined in alumni.orm.yml.

*   Twig

    Since this controller has many action, it needs many twig files.

        ../Resources/views/Master/Alumni/index.html.twig
        ../Resources/views/Master/Alumni/partial.table.html.twig
        ../Resources/views/List/filter/base.html.twig

*   Browser

        http://book2/app_dev.php/alumni/

*   Test

        Tests/Controller/Filter/AlumniControllerTest.php

### 3rd Party

*   Admin Bundle

    Sometimes you need other bundle, eg. Sonata. The famous admin bundle.

        vendor/sonata-project/*

*   Admin Form

    It might needs special directory,
    you are free to place it in any directory
    as long as you don't get yourself confused about it.

    Let's name it Admin directory as it is self explainatory.

        Admin/Category/CompetencyAdmin.php

*   Browser

        http://book2/app_dev.php/admin/iluni/book/category-competency/list


### Libraries

After many hours of refactoring,
you might end up with a base class to handle repeated task, a common helper,
an extension (e.g twig, or assetic), a service listener (e.g. form type)
or maybe a whole new class to handle specific things (e.g pager).

This bundle group together this special folder in library folder.
I just want to keep my folder tidy.


### Conclusion

That's all.

Now you can make any entity easier,
because you already have working example in this bundle.
