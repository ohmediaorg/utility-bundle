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

    private function getMaxlength(string $dataClass, string $property): ?int
    {
        $maxlengthGuess = $this->guesser->guessMaxLength($dataClass, $property);

        return $maxlengthGuess ? $maxlengthGuess->getValue() : null;
    }

    private function getPattern(string $dataClass, string $property): ?string
    {
        $patternGuess = $this->guesser->guessPattern($dataClass, $property);

        return $patternGuess ? $patternGuess->getValue() : null;
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $dataClass = $form->getParent()->getConfig()->getDataClass();
        $property = $form->getName();

        if (!$dataClass || !class_exists($dataClass)) {
            return;
        }

        if (!isset($view->vars['attr']['maxlength'])) {
            $maxLength = $this->getMaxlength($dataClass, $property);

            if ($maxLength) {
                $view->vars['attr']['maxlength'] = $maxLength;
            }
        }

        if (!isset($view->vars['attr']['pattern'])) {
            $pattern = $this->getPattern($dataClass, $property);

            if ($pattern) {
                $view->vars['attr']['pattern'] = $pattern;
            }
        }
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextType::class];
    }
}
