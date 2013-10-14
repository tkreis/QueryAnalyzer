<?php

namespace QueryAnalyzer;

use QueryAnalyzer\Listener\QueryAnalyzerListener;
use Zend\ModuleManager\Feature\ConfigProviderInterface;
use Zend\Mvc\MvcEvent;

class Module implements ConfigProviderInterface
{
    public function onBootstrap(MvcEvent $e)
    {
        $application            = $e->getApplication();
        $serviceManager         = $application->getServiceManager();

        if($serviceManager->has('Zend\Db\Adapter\Adapter')){
            $profiler = $serviceManager->get('Zend\Db\Adapter\Adapter')->getProfiler();
            $config = $serviceManager->get('config');

            if(isset($profiler) && $profiler instanceof \QueryAnalyzer\Db\Adapter\Profiler\QueryAnalyzerProfiler){
                $listener = new QueryAnalyzerListener(
                    $serviceManager->get('ViewRenderer'),
                    $profiler,
                    $config['queryanalyzer']
                );

                foreach($config['queryanalyzer']['loggers'] as $logger){
                    $listener->addLogger($serviceManager->get($logger));
                }

                $application->getEventManager()->getSharedManager()->attach('Zend\Mvc\Application', $listener, null);
            }
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/module.config.php';
    }

    public function getAutoloaderConfig()
    {
        return array(
            'Zend\Loader\StandardAutoloader' => array(
                'namespaces' => array(
                    __NAMESPACE__ => __DIR__ . '/src/' . __NAMESPACE__,
                ),
            ),
        );
    }
}