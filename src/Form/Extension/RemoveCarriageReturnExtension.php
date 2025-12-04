<?php

namespace OHMedia\UtilityBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\CallbackTransformer;
use Symfony\Component\Form\Extension\Core\Type\TextareaType;
use Symfony\Component\Form\FormBuilderInterface;

class RemoveCarriageReturnExtension extends AbstractTypeExtension
{
    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $removeCarriageReturn = function (?string $value): ?string {
            if ($value) {
                $value = str_replace(["\r\n", "\r"], "\n", $value);
            }

            return $value;
        };

        $builder->addModelTransformer(new CallbackTransformer(
            $removeCarriageReturn,
            $removeCarriageReturn,
        ));
    }

    public static function getExtendedTypes(): iterable
    {
        return [TextareaType::class];
    }
}
