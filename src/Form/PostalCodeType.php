<?php

namespace OHMedia\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class PostalCodeType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $builder
            ->addModelTransformer(new CallbackTransformer(
                function ($postalCode): string {
                    return strtoupper($postalCode);
                },
                function ($postalCode): string {
                    return strtoupper($postalCode);
                },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'help' => 'Must be in the form <b>S4N 6V1</b> or <b>S4N6V1</b>.',
            'help_html' => true,
            'attr' => [
                'pattern' => '[A-Za-z]\d[A-Za-z]\s?\d[A-Za-z]\d',
                'autocapitalize' => 'characters',
                'style' => 'text-transform:uppercase',
                'maxlength' => 7,
            ],
        ]);
    }

    public function getParent(): string
    {
        return TextType::class;
    }
}
