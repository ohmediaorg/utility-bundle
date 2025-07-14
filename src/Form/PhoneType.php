<?php

namespace OHMedia\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\TelType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PhoneType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'help' => 'Must be in the form <b>306-555-1234</b> or <b>3065551234</b>.',
            'help_html' => true,
            'attr' => [
                'pattern' => '\d{3}-?\d{3}-?\d{4}',
                'maxlength' => 12,
            ],
        ]);
    }

    public function getParent(): string
    {
        return TelType::class;
    }
}
