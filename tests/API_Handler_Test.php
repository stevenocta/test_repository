<?php
namespace Steven\Test;
include 'classes/API_Handler.php';

use PHPUnit\Framework\TestCase;


/**
 * API Handler Test Cases
 *
 * @author Steven Gunarso
 */
final class API_Handler_Test extends TestCase
{
    /**
     * @var API_Handler $api_handler API Handler class instance to be tested
     * @var String $target_url The Mock Data for the testing
     */
    private $api_handler;
    private $target_url;
    

    /**
     * Test Set Up function
     * Set-up the required variables for the testing
     * @return void
     */
    public function setUp(): void
    {
        $this->target_url = "http://www.google.com";
        $this->api_handler = new API_Handler($this->target_url);
    }

    /**
     * Test the contructor target endpoint passing
     * @return void
     */
    public function test_constructor(): void
    {
        $target_url_processed = $this->api_handler->get_target_endpoint();

        $this->assertSame($this->target_url, $target_url_processed);
    }
    
    /**
     * Test the cURL functionality 
     * It is expected to return empty array since it is targeting a random URL (in this case Google)
     * @return void
     */
    public function test_do_curl(): void
    {
        $target_url_processed = $this->api_handler->do_curl();

        $this->assertSame(array(), $target_url_processed);
    }
}