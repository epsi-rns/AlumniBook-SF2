Symfony2-MooTools-NoobSlide-Wrapper-Bundle
=========================================

This sfMooNoobSlidePlugin is for Symfony 2.1 and Mootools 1.3
This bundle is a wrapper for [MooTools noobSlide](http://www.efectorelativo.net/laboratory/noobSlide/).

Introduction
----------

There is two mode used in this plugin:

*   picasa album and
*   javascript files that hold photo array.
    sample javascript included in (del)/media/user/js/(/del)
    (del)not implemented here(/del)

AppKernel.php
----------------

Add NoobSlideBundle to your application kernel.
This bundle depend on MootoolsBundle.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            new Citra\Mootools\NoobSlideBundle\NoobSlideBundle(),
            ...
        );
        ...
    }

How to use
----------

For each mode you can put title and subtitle.
Here is sample for picasa mode in template:

    {# src/Iluni/BookBundle/Resources/views/Default/screenshot.html.twig #}
    {% extends 'IluniBookBundle:Common:layout.html.twig' %}

    {% block title %}Screenshot{% endblock %}

    {% use 'DiaBoxBundle::assets.html.twig' %}
    {% use 'NoobSlideBundle::assets.html.twig' %}

    {% block include_stylesheets %}
        {{ parent() }}
        {{ block('include_stylesheets_diabox') }}
        {{ block('include_stylesheets_noobslide') }}
    {% endblock %}

    {% block include_javascripts %}
        {{ parent() }}
        {{ block('include_javascripts_diabox') }}
        {{ block('include_javascripts_noobslide') }}
    {% endblock %}

    {% block inline_javascripts %}
        {{ parent() }}
        {{ block('inline_javascripts_diabox') }}
    {% endblock %}

    {% block body %}
        {% include 'NoobSlideBundle::noob.html.twig' with {
            'title'         : 'AlumniBook Screenshot',
            'subtitle'      : 'Any related AlumniBook ports.',
            'lightbox_type' : 'diabox',
            'picasa_user'   : 'epsi.rns',
            'picasa_album'  : 'AlumniBook'
        } %}
    {% endblock %}

The block name is up to your theme.

Lightbox
--------

You might want to choose lightbox from plugin parameter.

1.  Slimbox
2.  Mediabox Advance
3.  Diabox

This lightbox plugin come as external plugin with no dependencies.
Don't forget to manually activate lightbox assets as above in template
before activating noobslide.


License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
