<?php
include $this->dir . "/src/inc/graph.php";

$class = Request::postParam("class");
$div = Request::postParam("division");
if($class !== null && $div !== null)
  $candidates = $this->EC->getCandidates($class, $div);
else
  $candidates = $this->EC->getCandidates();

if(empty($candidates))
  die("");

$votes = $this->EC->count($candidates);

$data = array();
foreach($votes as $name => $votes){
  $data[$name] = $votes;
}

$cfg['title'] = 'Election Results';
$cfg['width'] = 600;
$cfg['height'] = 300;
$cfg['value-font-size'] = 4;
$cfg['key-font-size'] = 6;

$graph = new phpMyGraph();

ob_start();
  $graph->parseVerticalColumnGraph($data, $cfg);
$img = ob_get_clean();
echo base64_encode($img);
?> 
