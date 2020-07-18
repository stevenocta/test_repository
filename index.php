<?php
namespace Steven\Test;
include 'classes/API_Handler.php';
include 'classes/Data_Process.php';

$target_url = "http://agl-developer-test.azurewebsites.net/people.json";

try {
    $data_process = new Data_Process($target_url);
    $results = $data_process->perform_cats_processing();

    echo "<h2> Sorted Cats by Gender </h2>";
    echo $results;    
}
catch (Exception $e) {
    echo $e->getMessage();
}