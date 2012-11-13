Symfony2-MooTools-DiaBox-Wrapper-Plugin
=========================================

This DiaBoxPlugin is for Symfony 2.1 and Mootools 1.3/ 1.4.

This plugin is a wrapper for [Mike Nelson's Diabox](http://www.mikeonrails.com/diabox).
Have a look at original code at [github](http://www.github.com/mnelson/diabox).

How to use
----------

To activate lightbox in your page,
simply add javascript and stylesheet to your template.

    {# src/Iluni/BookBundle/Resources/views/Default/screenshot.html.twig #}
    {% extends 'IluniBookBundle:Common:layout.html.twig' %}
    {% use 'DiaBoxBundle::assets.html.twig' %}

    {% block include_stylesheets %}
        {{ parent() }}
        {{ block('include_stylesheets_diabox') }}
    {% endblock %}

    {% block include_javascripts %}
        {{ parent() }}
        {{ block('include_javascripts_diabox') }}
    {% endblock %}

The block name is up to your theme.

Modification
------------

With respect of Mootools 1.4 compatibility,
I have changed this line in diabox.js#365.

      // this.content().fade('hide');
      this.content().tween('opacity', 0);

License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
