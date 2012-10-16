Symfony2-MooTools-Bundle
========================

This bundle loads [MooTools](http://mootools.net/) 1.3
for use with Symfony 2.1.

It is unofficial and is considered not mature yet,
since symfony doesn't have accepatable dependency manager for asset.

How to use
----------

Please publish your asset after installing this plugin.

    $ php app/console assets:install web --symlink
    $ php app/console assetic:dump --env=prod

AppKernel.php
----------------

Add MootoolsBundle to your application kernel.
Many mootools-related-bundle depends on this bundle.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            ...
        );
        ...
    }

config.yml
----------------

This bundle use assetic. You need to register in assetic to use it.

    # Assetic Configuration
    assetic:
        bundles:
            - MootoolsBundle

Theme
----------

Sampe of using mootools in your theme:

    {# src/Citra/Theme/Oriclone/Resources/views/assets.html.twig #}
    {% use 'MootoolsBundle::assets.13.html.twig' %}
    ...

    {% block include_javascripts %}
        {{ block('mootools') }}
    {% endblock %}
    ...

Different theme/site may have different requirements,
so pick whatever suit your needs.


License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
