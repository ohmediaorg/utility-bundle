<?php

namespace OHMedia\UtilityBundle\Form;

use OHMedia\UtilityBundle\Entity\CallToAction;
use OHMedia\UtilityBundle\Service\EntityPathManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;
use Symfony\Component\OptionsResolver\OptionsResolver;

class CallToActionType extends AbstractType
{
    public function __construct(
        private EntityPathManager $entityPathManager,
    ) {
    }

    public function buildForm(FormBuilderInterface $builder, array $options): void
    {
        $entityChoices = $this->entityPathManager->getChoices();

        if ($entityChoices) {
            $builder->add('type', ChoiceType::class, [
                'label' => 'Link Type',
                'choices' => [
                    'Internal' => CallToAction::TYPE_INTERNAL,
                    'External' => CallToAction::TYPE_EXTERNAL,
                ],
            ]);

            $builder->add('entity', ChoiceType::class, [
                'label' => 'Internal Resource',
                'choices' => $entityChoices,
            ]);
        } else {
            $builder->add('type', HiddenType::class, [
                'data' => CallToAction::TYPE_EXTERNAL,
            ]);
        }

        $builder->add('url', UrlType::class, [
            'label' => 'External URL',
            'default_protocol' => null,
        ]);

        $builder->add('text');
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['TYPE_INTERNAL'] = CallToAction::TYPE_INTERNAL;
        $view->vars['TYPE_EXTERNAL'] = CallToAction::TYPE_EXTERNAL;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CallToAction::class,
        ]);
    }
}
