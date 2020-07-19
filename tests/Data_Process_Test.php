<?php
namespace Steven\Test;
include 'classes/Data_Process.php';

use PHPUnit\Framework\TestCase;

/**
 * Data Process Test Cases
 * Notes: I deliberately not testing the API Calls directly to the endpoint in these Test Cases and uses Mocks to simulate the data coming back from it
 *
 * @author Steven Gunarso
 */
final class Data_Process_Test extends \PHPUnit\Framework\TestCase
{
    /**
     * @var Data_Process $data_process Data Process class instance to be tested
     * @var Array $mock_data The Mock Data for the testing
     * @var Array $mock_results_array_cat The expected array of pets with cat type
     * @var Array $mock_results_array_meerkat The expected array of pets with meerkat type
     * @var Array $mock_html_output_cat The expected HTML outputs of pets with cat type
     * @var Array $mock_html_output_meerkat The expected HTML outputs of pets with meerkat type
     */
    private $data_process;
    private $mock_data;
    
    private $mock_results_array_cat;
    private $mock_results_array_meerkat;

    private $mock_html_output_cat;
    private $mock_html_output_meerkat;


    /**
     * Test Set Up function
     * Set-up the required variables for the testing
     * @return void
     */
    public function setUp(): void
    {
        $this->data_process = new Data_Process("http://www.google.com");
        $this->mock_data = array(
            array (
                "name" => "Sam",
                "gender" => "Male",
                "age" => 23,
                "pets" => array (
                    array(
                        "name" => "Scar",
                        "type" => "Cat",
                    ),
                    array(
                        "name" => "Mufasa",
                        "type" => "Cat"
                    ),
                )
            ),
            array (
                "name" => "Sarah",
                "gender" => "Female",
                "age" => 30,
                "pets" => array (
                    array(
                        "name" => "Nala",
                        "type" => "Cat",
                    ),
                    array(
                        "name" => "Timon",
                        "type" => "Meerkat"
                    ),
                )
            ),
        );

        $this->mock_results_array_cat = array (
            "male" => array (
                "Mufasa",
                "Scar"
            ),
            "female" => array (
                "Nala"
            )
        );

        $this->mock_results_array_meerkat = array (
            "male" => array (),
            "female" => array (
                "Timon"
            ),
        );

        $this->mock_html_output_cat = "<h3> Male </h3><ul><li>Mufasa</li><li>Scar</li></ul><h3> Female </h3><ul><li>Nala</li></ul>";
        
        $this->mock_html_output_meerkat = "<h3> Male </h3><ul></ul><h3> Female </h3><ul><li>Timon</li></ul>";
    }

    /**
     * Test Pet Data Array Processing for Cats
     * @return void
     */
    public function test_data_processing_cat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("cat");
        $this->assertSame($this->mock_results_array_cat, $this->data_process->produce_array_output());
    }

    /**
     * Test Pet Data Array Processing for Meerkats
     * @return void
     */
    public function test_data_processing_meerkat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("meerkat");
        $this->assertSame($this->mock_results_array_meerkat, $this->data_process->produce_array_output());
    }

    /**
     * Test Pet Data HTML Output for Cats
     * @return void
     */
    public function test_html_processing_cat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("cat");
        $this->assertSame($this->mock_html_output_cat, $this->data_process->produce_html_output());
    }

    /**
     * Test Pet Data HTML Output for Meerkats
     * @return void
     */
    public function test_html_processing_meerkat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("meerkat");
        $this->assertSame($this->mock_html_output_meerkat, $this->data_process->produce_html_output());
    }
}