Symfony2-MooTools-AutoValidator-Bundle
===========================================

This AutoValidatorBundle is for Symfony 2.1 and Mootools 1.3/ 1.4.

This bundle provide auto generated
client side inline validator (javascript)
based on properties in validation.yml.

# How to use

AppKernel.php
----------------

Add AutoValidatorBundle to your application kernel.
This bundle depend on MootoolsBundle.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            new Citra\Mootools\AutoValidatorBundle\AutoValidatorBundle(),
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
            - 'AutoValidatorBundle:Form:autovalidator_widget.html.twig'

Form Preparation
----------------

You need to configure your form/ filter:

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ...
            ->add('mootoolsvalidator', 'autovalidator', array(
                'bundle' => '@IluniBookBundle',
                'entity' => 'Iluni\BookBundle\Entity\Alumni'
            ));
            ...
    }



### Options:

There are include and exclude options made for you,
in case you want to configure validator class manually.

*   'include' => array('community_name' => 'required minLength:3')
*   'exclude' => array('name', 'gender')

You are allowed to copy and change the code
to suit your needs. e.g. port to jquery.

License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
