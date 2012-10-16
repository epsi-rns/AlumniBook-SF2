<?php
namespace Citra\Mootools\DatePickerBundle\Form\Type;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

/**
 * Rendered Mootools DatePicker
 * Using date field represent as text input.
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class DatePickerType extends AbstractType
{
    protected static $asset_loaded_count = 0;

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setDefaults(array(
            'input'  => 'string',
            'widget' => 'single_text',
            'required' => false,
            'load_asset' => false,
            'theme' => 'dashboard',
            'locale' => '',
            'toggle' => false,
            'format' => 'yyyy-MM-dd',
            'attr' => array('size' => '16'),
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        $requested_theme = $options['theme'];
        $available_theme = array('dashboard', 'jqui', 'vista');
        $is_available = in_array($requested_theme, $available_theme);
        $doc_picker_class = $is_available? "pickerClass: 'datepicker_${requested_theme}'" : '';

        $locale = $options['locale'];
        $doc_locale = $locale? "Locale.use('$locale');" : '';

        if (!$options['load_asset']) {
            // if load_asset then skip asset loading
            self::$asset_loaded_count ++;
        }

        $view->vars = array_replace($view->vars, array(
            'doc_picker_class' => $doc_picker_class,
            'doc_locale' => $doc_locale,
            'doc_toggle' => $options['toggle'],
            'asset_loaded' => (bool) self::$asset_loaded_count ++,
            'locale' =>  $locale? $locale: 'en-US'
        ));
    }

    public function getParent()
    {
        return 'date';
    }

    public function getName()
    {
        return 'datepicker';
    }
}

