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

    public function get_listing_data()
    {
        $curl_results = $this->do_curl();

        if (!empty($curl_results) && !empty($curl_results["data"])) {
            $this->main_list = $curl_results["data"];
        }
        else if (!empty($curl_results["error_message"])) {
            throw new \Exception($curl_results["error_message"]);
        }
        else {
            throw new \Exception("An error encountered when retrieving the data.");
        }
    }

    public function perform_pets_data_processing($pet_type)
    {
        $this->process_pets_list_by_gender($pet_type);
        $this->perform_pets_data_sorting();
    }

    public function produce_html_output()
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

    public function produce_array_output()
    {
        $output["male"] = $this->processed_list_male;
        $output["female"] = $this->processed_list_female;
        return $output;
    }

    protected function perform_pets_data_sorting()
    {
        sort($this->processed_list_male);
        sort($this->processed_list_female);
    }

    protected function process_pets_list_by_gender($pet_type)
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
                $this->processed_list_male = array_merge($this->processed_list_male, $this->process_pet_type($data["pets"], $pet_type));
            }
            else if (!empty($data["pets"]) && $current_gender == "female") {
                $this->processed_list_female = array_merge($this->processed_list_female, $this->process_pet_type($data["pets"], $pet_type));
            }
        }
    }

    protected function process_pet_type($pets, $pet_type)
    {
        $pet_names = array();
        foreach ($pets as $key => $pet) {
            if (!empty($pet["type"] && strtolower($pet["type"]) == $pet_type)) {

                if (!empty($pet["name"])) {
                    $pet_names[] = $pet["name"];
                } 
            }
        }

        return $pet_names;
    }

    public function get_main_list()
    {
        return $this->main_list;
    }

    public function set_main_list($main_list)
    {
        $this->main_list = $main_list;
    }

    public function get_processed_list_male()
    {
        return $this->processed_list_male;
    }

    public function set_processed_list_male($processed_list_male)
    {
        $this->processed_list_male = $processed_list_male;
    }

    public function get_processed_list_female()
    {
        return $this->processed_list_female;
    }

    public function set_processed_list_female($processed_list_female)
    {
        $this->processed_list_female = $processed_list_female;
    }
}