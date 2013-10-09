QueryAnalyzer
=============

Module that shows every executed query and the execution time.


##Setup
- Add "weteef/queryanalyzer": "dev-master" to the require section of your composer.json
- Attach Profiler to your DB-Adapter.
* For example $serviceManager
      ->get('Zend\Db\Adapter\Adapter')
      ->setProfiler(new \QueryAnalyzer\Db\Adapter\Profiler\QueryAnalyzerProfiler());

After these steps the analyzer should appear on the bottom right corner of your browser window.