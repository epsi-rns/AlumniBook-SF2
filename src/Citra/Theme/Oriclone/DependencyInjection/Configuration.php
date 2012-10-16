<?php

namespace Citra\Theme\Oriclone\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

/**
 * This is the class that validates and merges configuration from your app/config files
 *
 * @author E.R. Nurwijayadi <epsi.rns@gmail.com>
 */
class Configuration implements ConfigurationInterface
{
    /**
     * {@inheritDoc}
     */
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('oriclone');

        // Here you should define the parameters that are allowed to
        // configure your bundle. See the documentation linked above for
        // more information on that topic.

        $rootNode
            ->children()
                ->booleanNode('debug_css')->defaultFalse()->end()
                ->booleanNode('effects')->defaultTrue()->end()
                ->append($this->getLayoutNode())
                ->append($this->getModalNode())
                ->append($this->getErrorNode())
            ->end(); // children

        return $treeBuilder;
    }

    private function getLayoutNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('layout');

        $node
            ->children()
                ->scalarNode('sitename')
                    ->defaultValue('Oriclone')->end()
                ->scalarNode('logo')
                    ->defaultValue('logo-orb-yellow')->end()

                ->append($this->getLayoutCssNode())
                ->append($this->getLayoutClassesNode())
                ->append($this->getLayoutBlocksNode())
                ->append($this->getLayoutOptionsNode())
            ->end() // children
        ->end(); // layout node

        return $node;
    }

    private function getLayoutCssNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('css');

        $node
            ->children()
                ->scalarNode('text_scheme')
                    ->defaultValue('peachykeen')->end()
                ->scalarNode('strip_normal')
                    ->defaultValue('white-simple')->end()
                ->scalarNode('strip_hover')
                    ->defaultValue('ice')->end()
                ->scalarNode('marble')
                    ->defaultValue('mix')->end()
            ->end() // children
        ->end(); // css node

        return $node;
    }

    private function getLayoutClassesNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('classes');

        $node
            ->children()
                ->scalarNode('width_style')
                    ->defaultValue('fluid')->end()
                ->scalarNode('background_main')
                    ->defaultValue('white')->end()
                ->scalarNode('background_header')
                    ->defaultValue('grey_blue')->end()
                ->scalarNode('variation_top')
                    ->defaultValue('grad_black')->end()
            ->end() // children
        ->end(); // classes node

        return $node;
    }

    private function getLayoutBlocksNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('blocks');

        $node
            ->children()
                ->booleanNode('left')  ->defaultFalse()->end()
                ->booleanNode('right') ->defaultFalse()->end()
                ->booleanNode('top')   ->defaultFalse()->end()
                ->booleanNode('bottom')->defaultFalse()->end()
                ->booleanNode('main_bottom')->defaultFalse()->end()

                ->booleanNode('footer')->defaultFalse()->end()
                ->booleanNode('menumatic')->defaultFalse()->end()

                ->booleanNode('user1')->defaultFalse()->end()
                ->booleanNode('user2')->defaultFalse()->end()
                ->booleanNode('user3')->defaultFalse()->end()
                ->booleanNode('user4')->defaultFalse()->end()
            ->end() // children
        ->end(); // blocks node

        return $node;
    }

    private function getLayoutOptionsNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('options');

        $node
            ->children()
                ->scalarNode('top_layout')->defaultValue('pos_col1')->end()
            ->end() // children
        ->end(); // options node

        return $node;
    }

    private function getModalNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('modal');

        $node
            ->children()
                ->arrayNode('css')
                    ->children()
                        ->scalarNode('text_scheme')
                            ->defaultValue('peachykeen')->end()
                    ->end() // children
                ->end() // css
            ->end() // children
        ->end(); // modal node

        return $node;
    }

    private function getErrorNode()
    {
        $treeBuilder = new TreeBuilder();
        $node = $treeBuilder->root('error');

        $node
            ->children()
                ->scalarNode('code')
                    ->defaultValue('404')
                ->end()
                ->scalarNode('message')
                    ->defaultValue('The server returned a 404 response.')
                ->end()
                ->arrayNode('classes')
                    ->children()
                        ->scalarNode('width_style')
                            ->defaultValue('fluid')->end()
                        ->scalarNode('background_main')
                            ->defaultValue('feathers')->end()
                        ->scalarNode('background_header')
                            ->defaultValue('read')->end()
                    ->end() // children
                ->end() // classes
            ->end() // children
        ->end(); // error node

        return $node;
    }
}

