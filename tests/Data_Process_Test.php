<?php
namespace Steven\Test;
include 'classes/Data_Process.php';

use PHPUnit\Framework\TestCase;

final class Data_Process_Test extends \PHPUnit\Framework\TestCase
{
    private $data_process;
    private $mock_data;
    private $mock_results_array_cat;
    private $mock_results_array_meerkat;

    function setUp(): void
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
            'male' => array (
                'Mufasa',
                'Scar'
            ),
            'female' => array (
                'Nala'
            )
        );

        $this->mock_results_array_meerkat = array (
            'male' => array (),
            'female' => array (
                'Timon'
            ),
        );
    }

    public function test_data_processing_cat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("cat");
        $this->assertSame($this->mock_results_array_cat, $this->data_process->produce_array_output());
    }

    public function test_data_processing_meerkat(): void
    {
        $this->data_process->set_main_list($this->mock_data);
        $results = $this->data_process->perform_pets_data_processing("meerkat");
        $this->assertSame($this->mock_results_array_meerkat, $this->data_process->produce_array_output());
    }
}