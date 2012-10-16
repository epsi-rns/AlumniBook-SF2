Symfony2-LookupModal-Bundle
===========================

This LookupModalBundle is for Symfony 2.1 and Mootools 1.3.

This bundle doesn't really create a modal.
But rather prepare universal widget
for use in conjunction with any lightbox varians,
e.g. Diabox, Mediabox, or Slimbox.

Since it needs one long page of documentation.
It is released as bundle.

LookupModalBundle
------------------------

This widget has read only input text and hidden id
whose value can be changed via Diabox iframe modal.

This widget is registered in services.yml.
It also utilized data transformer.

The iframe modal itself triggered by a simple link.
Then the value and text sent back utilizing unobtrusive javascript.

How to use
----------

It is simple, but it has scattered parts in few steps.

*   Add mootools libraries to config.yml.
*   Activate lightbox plugin, in your project.
    It is a mandatory dependency. Mootools 1.3 required.
*   Activate this InputLookupModal plugin,
    or just copy this one file to your lib directory.
*   Prepare your form or formfilter to use this widget.
*   Create a regular page (not ajax),
    to be shown in your modal iframe.

AppKernel.php
----------------

Add LookupModalBundle to your application kernel.
This bundle depend on DiaBoxBundle.

    // app/AppKernel.php
    public function registerBundles()
    {
        $bundles = array(
            ...
            // project bundles
            new Citra\Mootools\SharedBundle\MootoolsBundle(),
            ...
            new Citra\Mootools\DiaBoxBundle\DiaBoxBundle(),
            new Citra\Mootools\LookupModalBundle\LookupModalBundle(),
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
                - 'LookupModalBundle:Form:lookupmodal_widget.html.twig'

Form Preparation
----------------

In your form builder the code included as sample below:

    public function buildForm(FormBuilderInterface $builder, array $options)
    {
        $builder
            ->add('community', 'lookupmodal', array(
                'class' => 'Iluni\BookBundle\Entity\Community',
                'link_text' => 'Pick Community',
                'link_title' => 'Lookup Community Name',
                'link_route' => 'modal_community'
            ));
    }

Parent Window
----------------

In your form template the code would looks like:

{# form.html.twig #}

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

    {% block inline_javascripts %}
        {{ parent() }}
        {{ block('inline_javascripts_diabox_frame') }}
    {% endblock %}

    {% block body %}
        ...
        <form action="{{ path }}" method="post" ...>
            ...
        </form>
        ...
    {% endblock %}

The block name is up to your theme.

This would render the template as:

    <label>Community</label>
    <input type="hidden"
        id="iluni_bookbundle_acommunitiestype_community_id"
        name="iluni_bookbundle_acommunitiestype[community][id]"
        value="2" />
    <input type="text"
        id="iluni_bookbundle_acommunitiestype_community_name"
        name="iluni_bookbundle_acommunitiestype[community][name]"
        readonly="readonly" value="Mesin (Regular)" />

    &nbsp;

    <img class="calendar pointer" alt="clear" title="clear"
        id="iluni_bookbundle_acommunitiestype_community_clear"
        src="/bundles/lookupmodal/images/tango/edit-clear.png" />
    &nbsp;
    <a href="/modal/community/"
        title="Lookup Community Name" class="icon_pick" rel="lightbox"
        >Pick Community</a>

    <script type="text/javascript">
    window.addEvent('domready', function() {
        el_lookup = document.id('iluni_bookbundle_acommunitiestype_community_id');
        el_select = document.id('iluni_bookbundle_acommunitiestype_community_name');
        el_clear  = document.id('iluni_bookbundle_acommunitiestype_community_clear');

        el_clear.addEvent('click', function() {
            el_lookup.set('value', '');
            el_select.set('value', '');
        });
    });
    </script>


IFrame Window
-------------

The rendered template above create ref to /modal/community/ .
The code in template would be:

    // /src/Iluni/BookBundle/Resources/views/Modal/index.html.twig

    <script type="text/javascript">
    window.addEvent('domready', function() {
        $$('.pick').addEvent('click', function(){
            window.parent.el_lookup.set('value', this.get('id'));
            window.parent.el_select.set('value', this.get('text'));
            window.parent.diabox.hide();
        });
    });

    </script>

    <a href="#" class="pick" id="2">Mesin (Regular)</a>

When it's clicked,
this would set hidden value to "2",
set the input text to 'Mesin (Regular)',
then it close the iframe Window.

License
-------

[MIT License](http://www.opensource.org/licenses/mit-license.php)
