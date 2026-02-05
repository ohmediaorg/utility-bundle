<?php

namespace OHMedia\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\OptionsResolver\OptionsResolver;

class ProvinceType extends AbstractType
{
    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'attr' => [
                'class' => 'nice-select2',
            ],
            'choices' => [
                'Alberta' => 'AB',
                'British Columbia' => 'BC',
                'Manitoba' => 'MB',
                'New Brunswick' => 'NB',
                'Newfoundland and Labrador' => 'NL',
                'Northwest Territories' => 'NT',
                'Nova Scotia' => 'NS',
                'Nunavut' => 'NU',
                'Ontario' => 'ON',
                'Prince Edward Island' => 'PE',
                'Quebec' => 'QC',
                'Saskatchewan' => 'SK',
                'Yukon' => 'YT',
            ],
        ]);
    }

    public function getParent(): string
    {
        return ChoiceType::class;
    }
}
