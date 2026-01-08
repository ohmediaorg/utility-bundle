<?php

namespace OHMedia\UtilityBundle\Form;

use OHMedia\UtilityBundle\Entity\CallToAction;
use OHMedia\UtilityBundle\Service\EntityPathManager;
use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\Event\PreSetDataEvent;
use Symfony\Component\Form\Extension\Core\Type\CheckboxType;
use Symfony\Component\Form\Extension\Core\Type\ChoiceType;
use Symfony\Component\Form\Extension\Core\Type\HiddenType;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\UrlType;
use Symfony\Component\Form\FormBuilderInterface;
use Symfony\Component\Form\FormEvents;
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
        $required = $options['required'];

        // NOTE: overriding 'label_attr' throughout
        // so the child fields appear required

        $builder->addEventListener(FormEvents::PRE_SET_DATA, function (PreSetDataEvent $event) use ($required) {
            $callToAction = $event->getData();
            $form = $event->getForm();

            $selectedEntity = $callToAction ? $callToAction->getEntity() : null;

            $entityChoices = $this->entityPathManager->getChoices($selectedEntity);

            if ($entityChoices) {
                $typeChoices = [];

                if (!$required) {
                    $typeChoices['None'] = CallToAction::TYPE_NONE;
                }

                $typeChoices['Internal'] = CallToAction::TYPE_INTERNAL;
                $typeChoices['External'] = CallToAction::TYPE_EXTERNAL;

                $form->add('type', ChoiceType::class, [
                    'label' => 'Link Type',
                    'choices' => $typeChoices,
                    'expanded' => true,
                    'row_attr' => [
                        'class' => 'fieldset-nostyle mb-3',
                    ],
                    'label_attr' => [
                        'class' => 'required',
                    ],
                ]);

                $form->add('entity', ChoiceType::class, [
                    'label' => 'Internal Resource',
                    'choices' => $entityChoices,
                    'row_attr' => [
                        'style' => $callToAction && $callToAction->isTypeInternal()
                            ? ''
                            : 'display:none',
                    ],
                    'placeholder' => '- Select -',
                    'help' => 'The link will not be displayed if the selected resource becomes unavailable to the public (eg. not published, requires login, deleted, etc.).',
                    'label_attr' => [
                        'class' => 'required',
                    ],
                    'attr' => [
                        'class' => 'nice-select2',
                    ],
                ]);

                $showUrl = $callToAction && $callToAction->isTypeExternal();

                $showOthers = $required || ($callToAction && !$callToAction->isTypeNone());
            } elseif (!$required) {
                $form->add('type', ChoiceType::class, [
                    'label' => 'Link Type',
                    'choices' => [
                        'None' => CallToAction::TYPE_NONE,
                        'External' => CallToAction::TYPE_EXTERNAL,
                    ],
                    'expanded' => true,
                    'row_attr' => [
                        'class' => 'fieldset-nostyle mb-3',
                    ],
                    'label_attr' => [
                        'class' => 'required',
                    ],
                ]);

                $showUrl = $callToAction && $callToAction->isTypeExternal();

                $showOthers = $callToAction && $callToAction->isTypeExternal();
            } else {
                $form->add('type', HiddenType::class, [
                    'data' => CallToAction::TYPE_EXTERNAL,
                ]);

                $showUrl = true;
                $showOthers = true;
            }

            $form->add('url', UrlType::class, [
                'label' => 'External URL',
                'default_protocol' => null,
                'row_attr' => [
                    'style' => $showUrl ? '' : 'display:none',
                ],
                'label_attr' => [
                    'class' => 'required',
                ],
            ]);

            $form->add('text', TextType::class, [
                'row_attr' => [
                    'style' => $showOthers ? '' : 'display:none',
                ],
                'label_attr' => [
                    'class' => 'required',
                ],
                'empty_data' => '',
            ]);

            $form->add('new_window', CheckboxType::class, [
                'required' => false,
                'label' => 'Open this link in a new window',
                'row_attr' => [
                    'style' => $showOthers ? '' : 'display:none',
                ],
            ]);
        });
    }

    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        $view->vars['TYPE_INTERNAL'] = CallToAction::TYPE_INTERNAL;
        $view->vars['TYPE_EXTERNAL'] = CallToAction::TYPE_EXTERNAL;
        $view->vars['TYPE_NONE'] = CallToAction::TYPE_NONE;
    }

    public function configureOptions(OptionsResolver $resolver): void
    {
        $resolver->setDefaults([
            'data_class' => CallToAction::class,
        ]);
    }
}
