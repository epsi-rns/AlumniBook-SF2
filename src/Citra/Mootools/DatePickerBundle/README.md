Symfony2-MooTools-DatePicker-Wrapper-Bundle
===========================================

This DatePickerBundle is for Symfony 2.1 and Mootools 1.3.
This bundle is a wrapper for [MooTools DatePicker](https://github.com/arian/mootools-datepicker/).

# How to use

AppKernel.php
----------------

Add DatePickerBundle to your application kernel.
This bundle depend on MootoolsBundle.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            new Citra\Mootools\DatePickerBundle\DatePickerBundle(),
            ...
        );
        ...
    }

Dependency injection will read bundle's services.yml.

config.yml
----------------

You need to register twig form resources when you want to use them.

    # Twig Configuration
    twig:
        form:
            resources:
            - 'DatePickerBundle:Form:datepicker_widget.html.twig'

Form Preparation
----------------

You need to configure your form/ filter:

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ...
            ->add('update_st', 'datepicker', array(
                'label'  => 'Update (start) Range'
            ))
            ->add('update_nd', 'datepicker', array(
                'label'  => 'Update (end) Range'
            ))
            ...
    }

### Options:

Currently there are three otions available.

*   theme: dashboard, jqui, vista
*   toggle: true, false
*   locale: en-US, de-DE, fr-FR, it-IT, nl-NL, cs-CZ, ru-RU

This plugin is intended to be simple and a quick fix.
Actually there are a bunch of cool options available in
[Mootools Datepicker](http://mootools.net/forge/p/mootools_datepicker)
that is not covered here.
You may want to change the code to suit your needs.

License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
