<?php

namespace OHMedia\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OneEmailPerLineType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'help' => 'Enter one email per line. Invalid emails will be removed.',
            'regex' => '/^[a-zA-Z0-9.!#$%&\'*+\\/=?^_`{|}~-]+@[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?(?:\.[a-zA-Z0-9](?:[a-zA-Z0-9-]{0,61}[a-zA-Z0-9])?)+$/D',
        ]);

        $resolver->setAllowedTypes('regex', 'string');
    }

    public function getParent(): string
    {
        return OnePerLineType::class;
    }
}
