<?php

namespace QueryAnalyzer\Db\Adapter\Profiler;

use Zend\Db\Adapter\Profiler\Profiler;
use Zend\Db\Adapter\StatementContainerInterface;

class QueryAnalyzerProfiler extends Profiler{

    protected $routingTrace = null;

    protected $applicationTrace = array();

    protected $fullBacktrace = array();

    /**
     * @param string|StatementContainerInterface $target
     * @throws \Zend\Db\Adapter\Exception\InvalidArgumentException
     * @return Profiler
     */
    public function profilerStart($target){
        $this->buildTraces(debug_backtrace());

        parent::profilerStart($target);

        $this->profiles[$this->currentIndex]['applicationTrace'] = $this->applicationTrace;
        $this->profiles[$this->currentIndex]['fullBacktrace'] = $this->fullBacktrace;

        return $this;
    }

    /**
     * @return Profiler
     */
    public function profilerFinish(){
        $this->resetTraces();

        return parent::profilerFinish();
    }

    public function getRoutingTrace(){
        return $this->routingTrace;
    }

    public function setRoutingTrace($trace){
        $this->routingTrace = $trace;
    }

    private function buildTraces($backtrace){
        // build full backtrace
        foreach($backtrace as $caller){
            if(isset($caller['class'])){
                if(isset($caller['line']))
                    $line = $caller['line'];
                $this->fullBacktrace[] = $caller['class'].$caller['type'].$caller['function'].'[Line: '.$line.']';
            }
        }

        // build application trace
        foreach($backtrace as $caller){
            if(isset($caller['class'])){
                if(strpos($caller['class'], "Zend") === false && strpos($caller['class'], "QueryAnalyzerProfiler") === false){
                    $string = $caller['class'].$caller['type'].$caller['function'];

                    if(isset($caller['line']))
                        $string .= ' [Line: '.$line.']';

                    $this->applicationTrace[] = $string;
                }
            }
        }
    }

    private function resetTraces(){
        $this->applicationTrace = array();
        $this->fullBacktrace = array();
    }

}