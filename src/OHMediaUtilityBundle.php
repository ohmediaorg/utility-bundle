<?php

namespace OHMedia\UtilityBundle;

use OHMedia\UtilityBundle\DependencyInjection\Compiler\EntityPathPass;
use OHMedia\UtilityBundle\Service\AbstractEntityPathProvider;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Loader\Configurator\ContainerConfigurator;
use Symfony\Component\HttpKernel\Bundle\AbstractBundle;

class OHMediaUtilityBundle extends AbstractBundle
{
    public function build(ContainerBuilder $container): void
    {
        parent::build($container);

        $container->addCompilerPass(new EntityPathPass());
    }

    public function loadExtension(
        array $config,
        ContainerConfigurator $containerConfigurator,
        ContainerBuilder $containerBuilder
    ): void {
        $containerConfigurator->import('../config/services.yaml');

        $containerBuilder->registerForAutoconfiguration(AbstractEntityPathProvider::class)
            ->addTag('oh_media_utility.entity_path_provider')
        ;

        $this->registerWidget($containerBuilder);
    }

    /**
     * Registers the form widget.
     */
    protected function registerWidget(ContainerBuilder $containerBuilder)
    {
        $resource = '@OHMediaUtility/form/call_to_action_widget.html.twig';

        $containerBuilder->setParameter('twig.form.resources', array_merge(
            $containerBuilder->getParameter('twig.form.resources'),
            [$resource]
        ));
    }
}
