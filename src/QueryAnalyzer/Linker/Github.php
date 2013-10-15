<?php 

namespace QueryAnalyzer\Linker;

class Github {
  private $repoUrl;
  private $branch;
  private $workingDirectoryLength;

  public function __construct($options){
    $this->repoUrl = $options['repoUrl'];
    $this->branch = $options['branch'];
    $this->workingDirectoryLength = strlen($options['workingDirectory']);
    $this->repositoryIdentifier = isset($options['repoIdentifier']) ?: '';
  }

  public function generateLink($fileName){
    return  $this->repoUrl . 'tree/'.$this->branch .'/'. substr($fileName, $this->workingDirectoryLength);
  }

  public function belongsToRepository(){
    return true;
  }
}

