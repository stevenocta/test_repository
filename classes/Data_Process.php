<?php
namespace Steven\Test;

/**
 * Data Processing for the Pets Data
 *
 * @author Steven Gunarso
 */
class Data_Process extends API_Handler
{
    /**
     * @var Array $main_list The main array of pets
     * @var Array $processed_list_male The array of pets with male owners
     * @var Array $processed_list_female The array of pets with female owners
     */
    protected $main_list, $processed_list_male, $processed_list_female;


    /**
     * Class Constructor
     * The Contructor also initialise the main array, genders arrays and the target endpoints of the parent API Handler class.
     * @param String $target_endpoint The URL Endpoint source of the data
     * @return void
     */
    public function __construct($target_endpoint)
    {
        $this->main_list = array();
        $this->processed_list_male = array();
        $this->processed_list_female = array();

        parent::__construct($target_endpoint);
    }

    /**
     * Perform cURL API Call to get the Pet Listing Data
     * Perform the API Call to the target endpoint and assign the resulting array to the Main Pets Array.
     * If the cURL function (from API Handler) returns any errors, then throw an Exception to the public PHP script.
     * @return void
     * @throws Exception If there is any errors being detected / there is no response from cURL function (timeout)
     */
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

    /**
     * Perform Pets Data Processing 
     * This function allows the triggering of the pets data processing into the gender arrays based on their pet type from the public PHP script.
     * @param String $pet_type The target pet type to search
     * @return void
     */
    public function perform_pets_data_processing($pet_type)
    {
        $this->process_pets_list_by_gender($pet_type);
        $this->perform_pets_data_sorting();
    }

    /**
     * Produce HTML Output
     * This function will output the processed arrays as plain HTML heading and list.
     * @return String
     */
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

    /**
     * Produce Array Output
     * This function will output the processed arrays as PHP arrays.
     * @return Array
     */
    public function produce_array_output()
    {
        $output["male"] = $this->processed_list_male;
        $output["female"] = $this->processed_list_female;
        return $output;
    }

    /**
     * Sort the Processed Pet Names
     * This function will sort the processed Pet Names with each genders arrays into alphabetical order.
     * @return void
     */
    protected function perform_pets_data_sorting()
    {
        sort($this->processed_list_male);
        sort($this->processed_list_female);
    }

    /**
     * Process the Pet Owner Array by Gender
     * This function will differentiate the Pet Owner's genders and assign the pet name with correct pet type under the correct gender arrays.
     * @param String $pet_type The target pet type to search
     * @return void
     */
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

    /**
     * Process the Pets Names Array by Type
     * This function will return an array of pet names with the specified pet type (e.g. cat).
     * @param Array $pets The array of pets from cURL / get methods 
     * @param String $pet_type The target pet type to search
     * @return Array
     */
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

    /**
     * Get the Pets Array 
     * @return Array
     */
    public function get_main_list()
    {
        return $this->main_list;
    }

    /**
     * Set the Initial Data Array
     * This function will overwrite the get_listing_data (cURL) function results.
     * @param Array $main_list The new unprocessed pets array
     * @return void
     */
    public function set_main_list($main_list)
    {
        $this->main_list = $main_list;
    }

    /**
     * Get the Male Pets Array 
     * @return Array
     */
    public function get_processed_list_male()
    {
        return $this->processed_list_male;
    }

    /**
     * Set the Processed Male Pets 
     * This function will overwrite the male pets array.
     * @param Array $processed_list_male The new male pets array
     * @return void
     */
    public function set_processed_list_male($processed_list_male)
    {
        $this->processed_list_male = $processed_list_male;
    }

    /**
     * Get the Female Pets Array 
     * @return Array
     */
    public function get_processed_list_female()
    {
        return $this->processed_list_female;
    }

    /**
     * Set the Processed Female Pets 
     * This function will overwrite the female pets array.
     * @param Array $processed_list_female The new female pets array
     * @return void
     */
    public function set_processed_list_female($processed_list_female)
    {
        $this->processed_list_female = $processed_list_female;
    }
}