<?
namespace Seyon\Teamspeak3\ViewerBundle\DependencyInjection;

use Symfony\Component\Config\Definition\Builder\TreeBuilder;
use Symfony\Component\Config\Definition\ConfigurationInterface;

class Configuration implements ConfigurationInterface
{
    public function getConfigTreeBuilder()
    {
        $treeBuilder = new TreeBuilder();
        $rootNode = $treeBuilder->root('seyon_teamspeak3_viewer');

        $rootNode
            ->children()
                ->scalarNode('user')
                    ->isRequired()
                ->end()
                ->scalarNode('pass') 
                    ->isRequired()
                ->end()
                ->scalarNode('host') 
                    ->isRequired()
                ->end()
                ->scalarNode('query') 
                    ->defaultValue('10011')
                    ->isRequired()
                ->end()
                ->scalarNode('voice') 
                    ->defaultValue('8987')
                    ->isRequired()
                ->end()
                ->scalarNode('template') 
                    ->defaultValue('SeyonTeamspeak3ViewerBundle::layout.html.twig')
                    ->isRequired()
                ->end()
            ->end();

        return $treeBuilder;
    }
}