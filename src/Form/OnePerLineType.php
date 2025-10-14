<?php

namespace OHMedia\UtilityBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\OptionsResolver\OptionsResolver;

class OnePerLineType extends AbstractType
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $regex = $options['regex'];

        $builder
            ->addModelTransformer(new CallbackTransformer(
                function (?array $lines): string {
                    return $lines ? implode("\n", $lines) : '';
                },
                function (?string $lines) use ($regex): ?array {
                    if (!$lines) {
                        return null;
                    }

                    $lines = explode("\n", $lines);

                    $return = [];

                    foreach ($lines as $line) {
                        $line = trim($line);

                        if ($line && preg_match($regex, $line)) {
                            $return[] = $line;
                        }
                    }

                    return $return ?: null;
                },
            ))
        ;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'help' => 'Enter one per line. Blank lines will be removed.',
            'regex' => '/(.|\s)*\S(.|\s)*/',
            'attr' => [
                'rows' => 5,
            ],
        ]);

        $resolver->setAllowedTypes('regex', 'string');
    }

    public function getParent(): string
    {
        return TextareaType::class;
    }
}
