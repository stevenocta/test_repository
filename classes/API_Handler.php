<?php
namespace Steven\Test;

/**
 * API cURL Handler class
 *
 * @author Steven Gunarso
 */
class API_Handler
{
    /**
     * @var String $target_endpoint The target Endpoint URL for cURL
     */
    protected $target_endpoint;


    /**
     * Class Constructor
     * @param String $target_endpoint The URL Endpoint source of the data
     * @return void
     */
    public function __construct($target_endpoint)
    {
        if (!empty($target_endpoint)) {
            $this->target_endpoint = $target_endpoint;
        }
    }

    /**
     * Perform cURL API Call
     * Error Array will be thrown if any exception is detected and returned as a result array.
     * If the target Endpoint not returning any arrays (e.g. got a wrong URL), an empty results array will be returned instead.
     * @return Array
     */
    public function do_curl()
    {
        $results = array();

        try {
            $conn = $this->init_curl();
            $conn = $this->init_curl_headers($conn);
            
            $data = curl_exec($conn);

            if (!empty($data) && json_decode($data)) {
                // ensure that we are getting array as results
                $results["data"] = json_decode($data, true);
            }
            else if (is_array($data)) {
                $results["data"] = $data;
            }
            
            $this->close_curl($conn);    
        }
        catch (\Exception $e) {
            $results["error"] = true;
            $results["error_message"] = $e->getMessage();
        }

        return $results;
    }


    /**
     * Perform cURL initialisation
     * @return Object
     */
    protected function init_curl()
    {
        return curl_init();
    }
    
    /**
     * Perform cURL Header operations 
     * @param Object $conn Active cURL object generated from init 
     * @return Object
     */
    protected function init_curl_headers($conn)
    {
        curl_setopt($conn, CURLOPT_URL, $this->target_endpoint);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        return $conn;
    }

    /**
     * Perform cURL connection closing
     * @param Object $conn Active cURL object generated from init 
     * @return void
     */
    protected function close_curl($conn)
    {
        curl_close($conn);
    }
    
    /**
     * Get the Target Endpoint 
     * @return String
     */
    public function get_target_endpoint()
    {
        return $this->target_endpoint;
    }

    /**
     * Set the Target Endpoint 
     * This function will overwrite the endpoint set-up in the Constructor.
     * @param String $target_endpoint The new Target Endpoint URL 
     * @return void
     */
    public function set_target_endpoint($target_endpoint)
    {
        $this->target_endpoint = $target_endpoint;
    }
}