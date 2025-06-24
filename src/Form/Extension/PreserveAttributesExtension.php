<?php

namespace OHMedia\UtilityBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PreserveAttributesExtension extends AbstractTypeExtension
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $dataClass = $form->getParent()->getConfig()->getOption('data_class');
        $property = $form->getName();

        if (!$dataClass || !class_exists($dataClass)) {
            return;
        }

        $metadata = $this->validator->getMetadataFor($dataClass);
        if (!method_exists($metadata, 'getPropertyMetadata')) {
            return;
        }

        $test = $metadata->getPropertyMetadata($property);

        $maxlength = null;
        foreach ($metadata->getPropertyMetadata($property) as $propMeta) {
            $testTwo = $propMeta->getConstraints();

            foreach ($propMeta->getConstraints() as $constraint) {
                if ($constraint instanceof Length && $constraint->max) {
                    $maxlength = $constraint->max;
                    break 2;
                }
            }
        }

        if ($maxlength) {
            $view->vars['attr']['maxlength'] ??= $maxlength;
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }
}
