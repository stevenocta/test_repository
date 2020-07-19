<?php
namespace Steven\Test;
include 'classes/API_Handler.php';
include 'classes/Data_Process.php';

$target_url = "http://agl-developer-test.azurewebsites.net/people.json";

try {
    $data_process = new Data_Process($target_url);

    // run the cURL to get the pet cat listing
    $data_process->get_listing_data();
    $data_process->perform_pets_data_processing("cat");
    $results = $data_process->produce_html_output();

    echo "<h2> Sorted Cats by Gender </h2>";
    echo $results;    
}
catch (\Exception $e) {
    echo $e->getMessage();
}