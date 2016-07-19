<?php
$class = Request::postParam("class");
$div = Request::postParam("division");

if($class !== null && $div !== null){
  echo $this->EC->showCandidates($class, $div);
}
