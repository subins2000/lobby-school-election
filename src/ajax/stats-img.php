<?php
include $this->dir . "/src/inc/graph.php";

$data = array();

// Set config directives
$cfg['title'] = 'Election Results';
$cfg['width'] = 600;
$cfg['height'] = 300;
$cfg['value-font-size'] = 4;
$cfg['key-font-size'] = 6;

$candidates = $this->EC->getCandidates();
$votes = $this->EC->count($candidates);

foreach($votes as $name => $votes){
  $data[$name] = $votes;
}

$graph = new phpMyGraph();

ob_start();
  $graph->parseVerticalColumnGraph($data, $cfg);
$img = ob_get_clean();
echo base64_encode($img);
?> 
