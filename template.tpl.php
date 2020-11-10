<?php

$JSONString = $content;
$String = implode('<br>', json_decode($JSONString));
echo $String;

?>