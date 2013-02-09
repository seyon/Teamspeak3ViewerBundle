<?
namespace Seyon\Teamspeak3\ViewerBundle\DependencyInjection;

use Symfony\Component\HttpKernel\DependencyInjection\Extension;
use Symfony\Component\DependencyInjection\ContainerBuilder;
use Symfony\Component\Config\FileLocator;
use Symfony\Component\DependencyInjection\Loader\YamlFileLoader;
use Symfony\Component\DependencyInjection\Extension\PrependExtensionInterface;

class SeyonTeamspeak3ViewerExtension extends Extension implements PrependExtensionInterface 
{
    
    public function prepend(ContainerBuilder $container)
    {
        
        $loader = new YamlFileLoader($container, new FileLocator(__DIR__.'/../Resources/config'));
        $loader->load('config.yml');

    }
    
    public function load(array $configs, ContainerBuilder $container)
    {
        $config = array();
        
        // reverse array, 
        // the main config file is the first but we will that 
        // the config part from the main will be used
        $configs = array_reverse($configs);
        foreach ($configs as $subConfig) {
            $config = array_merge($config, $subConfig);
        }
      
        $configuration = new Configuration();
        $config = $this->processConfiguration($configuration, array($config));

        $container->setParameter('seyon_teamspeak3_viewer', $config);
        
    }

}