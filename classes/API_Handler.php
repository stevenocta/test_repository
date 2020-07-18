<?php
namespace Steven\Test;

class API_Handler
{
    protected $target_endpoint;

    public function __construct($target_endpoint)
    {
        if (!empty($target_endpoint)) {
            $this->target_endpoint = $target_endpoint;
        }
    }

    protected function do_curl()
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
        catch (Exception $e) {
            $results["error"] = true;
            $results["error_message"] = $e->getMessage();
        }

        return $results;
    }

    protected function init_curl()
    {
        return curl_init();
    }

    protected function init_curl_headers($conn)
    {
        curl_setopt($conn, CURLOPT_URL, $this->target_endpoint);
        curl_setopt($conn, CURLOPT_RETURNTRANSFER, 1);
        return $conn;
    }

    protected function close_curl($conn)
    {
        curl_close($conn);
    }

    public function get_target_endpoint()
    {
        return $this->target_endpoint;
    }

    public function set_target_endpoint($target_endpoint)
    {
        $this->target_endpoint = $target_endpoint;
    }
}