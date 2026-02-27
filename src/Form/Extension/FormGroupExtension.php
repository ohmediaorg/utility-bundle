<?php

namespace OHMedia\UtilityBundle\Form\Extension;

use Symfony\Component\Form\AbstractTypeExtension;
use Symfony\Component\Form\Extension\Core\Type\ButtonType;
use Symfony\Component\Form\Extension\Core\Type\FormType;
use Symfony\Component\Form\FormInterface;
use Symfony\Component\Form\FormView;

class FormGroupExtension extends AbstractTypeExtension
{
    public function buildView(FormView $view, FormInterface $form, array $options): void
    {
        if (!isset($view->vars['row_attr'])) {
            $view->vars['row_attr'] = [];
        }

        if (!isset($view->vars['row_attr']['class'])) {
            $view->vars['row_attr']['class'] = '';
        }

        $classes = explode(' ', $view->vars['row_attr']['class']);

        if (!in_array('form-group', $classes)) {
            $classes[] = 'form-group';
        }

        $view->vars['row_attr']['class'] = implode(' ', $classes);
    }

    public static function getExtendedTypes(): iterable
    {
        return [
            FormType::class,
            ButtonType::class,
        ];
    }
}
