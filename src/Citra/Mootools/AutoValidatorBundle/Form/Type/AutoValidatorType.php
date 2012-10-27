<?php
namespace Citra\Mootools\AutoValidatorBundle\Form\Type;

use Symfony\Component\DependencyInjection\ContainerInterface;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

use Symfony\Component\OptionsResolver\Options;
use Symfony\Component\OptionsResolver\OptionsResolverInterface;

use Symfony\Component\Validator\Validation;
use Symfony\Component\Form\Extension\Validator\ValidatorExtension;

/**
 * Rendered Mootools AutoValidator
 *
 * Provide auto generated client side inline validator (javascript)
 * based on properties in validation.yml
 *
 * Supported class: \NotBlank, \Length, \Type/Integer
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class AutoValidatorType extends AbstractType
{
    private $kernel; // KernelInterface
    private $namespace = 'Symfony\Component\Validator\Constraints';

    public function __construct(ContainerInterface $container)
    {
        $this->kernel = $container->get('kernel');
    }

    public function setDefaultOptions(OptionsResolverInterface $resolver)
    {
        $resolver->setOptional(array('bundle', 'entity'));

        $resolver->setDefaults(array(
            // override default
            'mapped' => false,
            // optional
            'form_id' => 'form_validate',
            'include' => [],    // fieldname => text
            'exclude' => []     // fieldname
        ));
    }

    public function buildView(FormView $view, FormInterface $form, array $options)
    {
        if (isset($options['entity']) and isset($options['entity'])) {
            $properties = $this->getEntityProperties($options);
            $fields = $this->buildValidator($properties);
        } else {
            $fields = [];   // 5.4 syntax
        }
        $fields = $this->mergeManualValidator($options, $fields);

        $view->vars = array_replace($view->vars, array(
            'form_id' => $options['form_id'],
            'fields'  => $fields
        ));
    }

    private function mergeManualValidator($options, $fields)
    {
        $fields = array_filter($fields);
        $fields = array_merge($fields, $options['include']);
        $fields = array_diff_key($fields, array_flip($options['exclude']));

        return $fields;
    }

    private function buildValidator($properties)
    {
        // restructure, and parse
        $fields = [];
        foreach ($properties as $field => $metadata) {
            $inlines = [];
            foreach ($metadata->constraints as $constraint) {
                $inlines[] = $this->parseValidator($constraint);
            }

            $inlines = array_filter($inlines);
            $fields[$field] = implode(' ', $inlines);
        }

        return $fields;
    }

    private function parseValidator($constraint)
    {
        $classname = get_Class($constraint);
        $validator = str_replace($this->namespace, '', $classname);

        switch($validator) {
            case '\NotBlank':
                $inline = 'required';
                break;

            case '\Length':
                $text = [];
                if (isset($constraint->min)) {
                    $text[] = 'minLength:'.$constraint->min;
                }
                if (isset($constraint->max)) {
                    $text[] = 'maxLength:'.$constraint->max;
                }
                $inline = implode(' ', $text);
                break;

            case '\Type':
                $inline = '';
                if (isset($constraint->type)) {
                    if ($constraint->type=='integer') {
                        $inline = 'validate-integer';
                    }
                }
                break;

            default:
                $inline = '';
        }

        return $inline;
    }

    private function getEntityProperties(array $options)
    {
        $file = '/Resources/config/validation.yml';
        $path = $this->kernel->locateResource($options['bundle'].$file);

        $validatorBuilder = Validation::createValidatorBuilder();
        $validatorBuilder->addYamlMapping($path);
        $validator = $validatorBuilder->getValidator();

        // Must use FQCN
        $metadataFactory = $validator->getMetadataFactory();
        $metadata = $metadataFactory->getClassMetadata($options['entity']);

        return $metadata->properties;
    }

    public function getParent()
    {
        return 'hidden';
    }

    public function getName()
    {
        return 'autovalidator';
    }
}

