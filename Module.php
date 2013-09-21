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
        $sharedEventManager     = $application->getEventManager()->getSharedManager();

        $profiler               = $serviceManager->get('Zend\Db\Adapter\Adapter')->getProfiler();

        if(isset($profiler)){
            $sharedEventManager->attach('Zend\Mvc\Application', new QueryAnalyzerListener($serviceManager->get('ViewRenderer'), $profiler), null);
        }
    }

    public function getConfig()
    {
        return include __DIR__ . '/config/queryanalyzer.config.php';
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