<?php

namespace OHMedia\UtilityBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Validator\ValidatorTypeGuesser;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class PreserveAttributesExtension extends AbstractTypeExtension
{
    public function __construct(private ValidatorTypeGuesser $guesser)
    {
    }

    private function setMaxlength(string $dataClass, string $property, FormView $view): void
    {
        $maxlengthGuess = $this->guesser->guessMaxLength($dataClass, $property);
        if ($maxlengthGuess && $maxlengthGuess->getValue()) {
            $view->vars['attr']['maxlength'] ??= $maxlengthGuess->getValue();
        }
    }

    private function setPattern(string $dataClass, string $property, FormView $view): void
    {
        $patternGuess = $this->guesser->guessPattern($dataClass, $property);
        if ($patternGuess && $patternGuess->getValue()) {
            $view->vars['attr']['pattern'] ??= $patternGuess->getValue();
        }
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $dataClass = $form->getParent()->getConfig()->getOption('data_class');
        $property = $form->getName();

        if (!$dataClass || !class_exists($dataClass)) {
            return;
        }

        $this->setMaxlength($dataClass, $property, $view);
        $this->setPattern($dataClass, $property, $view);
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }
}
