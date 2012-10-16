Oriclone Theme
==============

My personal theme, the original clone.
Although I've made it from scratch, it is inspired by other design.
This theme is for Symfony 2.1, and soft dependency with mootools 1.3.

Feature
-------

*   Some theme effects.
    Require mootools 1.3, but you can turn it off.
*   (del)Layout testing CSS(/del)
*   Symfony layout:  layout, error404 and modal.
*   (del)CSS compressor task class(/del)
*   Custom 404 error page.
*   Control parameter via config.yml
*   (del)A few source images (XCF's GIMP), only small files.(/del)


About
-----

Don't mind the looks, I'm not a designer.
You are free to use or modify this template in your site

You may want to take a look at the source code
and adapt oriclone to your own template.

Here in this template, you might find challenging techniques.

This template is designed from scratch.
Although it is inspired by other template like *MittWoch*'s side menu,
it is actually original.

AppKernel.php
----------------

Add OricloneBundle to your application kernel.
This bundle recommend MootoolsBundle, bit it is not obligatory.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            ...
            new Citra\Theme\Oriclone\OricloneBundle(),
            ...
        );
        ...
    }



config.yml
----------------

Built in configuration should be imported first.

    imports:
        - { resource: "@OricloneBundle/Resources/config/config.yml" }

This bundle use assetic. You need to register in assetic to use it.

    # Assetic Configuration
    assetic:
        bundles:
            - OricloneBundle

Add Blocks
----------

(del)Not mature yet(/del)

You can add blocks easily with config.yml.
You can also modifydefault configuration for sitename and logo class.

    #  app/config/config.yml
    oriclone:
        layout:
            sitename:    AlumniBook
            logo:        logo-orikara

            classes:
                background_header: yellow
                variation_top:     ""

Modify CSS
----------

You can change this theme to suits your needs.
e.g. disable mootools effects, or turn off css debug.
Turning of css debug will change your css from style.css to import.css.

Just modify and add these line in your frontend app.yml.

    #  app/config/config.yml
    oriclone:
        # optional
        debug_css: true
        effects:   false

When you are done with your modification,
(del)turn off debug_css and do CSS compressor task:(/del)

    (del)php symfony oriclone:compress-css(/del)

(del)Source Images(/del)
-------------

I had cloned any necessary images using GIMP.
Shareable GIMP source also available.
Small XCF files included here,
while I keep most XCF at home to keep the theme small.
Just mail me if you need.

Please consider it as learning purpose and personal only.
The GIMP source in XCF is *shareable*.
That means you can add more customizable variation of color and style.

Have fun!


History
-------

This oriclone Theme for Symfony is a port for
previous Oriclone Theme for Joomla and Oriclone theme for BuddyPress.

The original contain many mootools effects and more stylesheets.



Catatan untuk pengguna Indonesia
--------------------------------

Dilarang keras:

    Menggunakan template ini secara liar
    dengan tujuan untuk mengatasnamakan iluni
    ataupun mengkaitkan situs dengan Universitas Indonesia
    tanpa ijin tertulis ketua iluni atau wakil ketua ex-officio.

Selain itu bebas.

How to use
----------

All you need to do is extends layout in application templates.

    {# app/Resources/views/base.html.twig #}
    {% extends 'OricloneBundle::base.html.twig' %}
    ...

License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
