<?php
namespace Steven\Test;

class Data_Process extends API_Handler
{
    protected $main_list;
    protected $processed_list_male;
    protected $processed_list_female;

    public function __construct($target_endpoint)
    {
        $this->main_list = array();
        $this->processed_list_male = array();
        $this->processed_list_female = array();

        parent::__construct($target_endpoint);
    }

    public function perform_cats_processing()
    {
        $this->main_list = $this->get_listing_data();
        $this->process_list_by_gender();
        $this->perform_data_sorting();

        return $this->produce_output_for_cats();
    }

    protected function produce_output_for_cats()
    {
        $output = "<h3> Male </h3>";
        $output .= "<ul>";
        foreach ($this->processed_list_male as $key => $item) {
            $output .= "<li>" . $item . "</li>";
        }
        $output .= "</ul>";

        $output .= "<h3> Female </h3>";
        $output .= "<ul>";
        foreach ($this->processed_list_female as $key => $item) {
            $output .= "<li>" . $item . "</li>";
        }
        $output .= "</ul>";

        return $output;
    }

    protected function perform_data_sorting()
    {
        sort($this->processed_list_male);
        sort($this->processed_list_female);
    }

    protected function process_list_by_gender()
    {
        $processed_list = array();

        foreach ($this->main_list as $key => $data) {
            
            if (!empty($data["gender"]) && strtolower($data["gender"]) == "male") {
                $current_gender = "male";
            }
            else if (!empty($data["gender"]) && strtolower($data["gender"]) == "female") {
                $current_gender = "female";
            }

            if (!empty($data["pets"]) && $current_gender == "male") {
                $this->processed_list_male = array_merge($this->processed_list_male, $this->process_pet_cats($data["pets"]));
            }
            else if (!empty($data["pets"]) && $current_gender == "female") {
                $this->processed_list_female = array_merge($this->processed_list_female, $this->process_pet_cats($data["pets"]));
            }
        }
    }

    protected function process_pet_cats($pets)
    {
        $pet_names = array();
        foreach ($pets as $key => $pet) {
            if (!empty($pet["type"] && strtolower($pet["type"]) == "cat")) {

                if (!empty($pet["name"])) {
                    $pet_names[] = $pet["name"];
                } 
            }
        }

        return $pet_names;
    }

    protected function get_listing_data()
    {
        $curl_results = $this->do_curl();
        $listing_data = false;

        if (!empty($curl_results) && !empty($curl_results["data"])) {
            $listing_data = $curl_results["data"];
        }
        else if ($curl_results["error_message"]) {
            throw new Exception($curl_results["error_message"]);
        }
        else {
            throw new Exception("An error encountered when retrieving the data.");
        }

        return $listing_data;
    }
}