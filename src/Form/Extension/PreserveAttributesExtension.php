<?php

namespace OHMedia\UtilityBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Component\Validator\Constraints\Regex;
use Symfony\Component\Validator\Validator\ValidatorInterface;

class PreserveAttributesExtension extends AbstractTypeExtension
{
    public function __construct(private ValidatorInterface $validator)
    {
    }

    // TODO types
    private function setMaxlength($metadata, $property, FormView $view): void
    {
        foreach ($metadata->getPropertyMetadata($property) as $propMeta) {
            foreach ($propMeta->getConstraints() as $constraint) {
                if ($constraint instanceof Length && $constraint->max) {
                    $view->vars['attr']['maxlength'] ??= $constraint->max;
                    return;
                }
            }
        }
    }

    private function setPattern($metadata, $property, FormView $view): void
    {
        // TODO DRY
        foreach ($metadata->getPropertyMetadata($property) as $propMeta) {
            foreach ($propMeta->getConstraints() as $constraint) {
                if ($constraint instanceof Regex && $constraint->pattern) {
                    $view->vars['attr']['pattern'] ??= $constraint->pattern;
                    return;
                }
            }
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $dataClass = $form->getParent()->getConfig()->getOption('data_class');
        $property = $form->getName();

        // TODO
        $innerType = $form->getConfig()->getType()->getInnerType();
        $type = $form->getConfig()->getType();

        if (!$dataClass || !class_exists($dataClass)) {
            return;
        }

        $metadata = $this->validator->getMetadataFor($dataClass);
        if (!method_exists($metadata, 'getPropertyMetadata')) {
            return;
        }

        $this->setMaxlength($metadata, $property, $view);
        $this->setPattern($metadata, $property, $view);
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }
}
