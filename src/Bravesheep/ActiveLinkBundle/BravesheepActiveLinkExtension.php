<?php

namespace Bravesheep\ActiveLinkBundle;

use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\DependencyInjection\Extension\Extension;
use Symfony\Component\DependencyInjection\Reference;

class BravesheepActiveLinkExtension extends Extension
{
    /**
     * {@inheritdoc}
     */
    public function load(array $config, ContainerBuilder $container)
    {
        // checker
        $container->register('bravesheep_active_link.checker', 'Bravesheep\\ActiveLinkBundle\\ActiveChecker')
            ->addArgument(new Reference('kernel'))
            ->addArgument(new Reference('request_stack'))
        ;

        // twig extension
        $container->register(
            'bravesheep_active_link.twig',
            'Bravesheep\\ActiveLinkBundle\\Twig\\BravesheepActiveLinkExtension'
        )
            ->addArgument(new Reference('bravesheep_active_link.checker'))
            ->addTag('twig.extension')
        ;
    }
}
