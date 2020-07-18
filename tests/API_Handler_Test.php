<?php
namespace Steven\Test;
include 'classes/API_Handler.php';

use PHPUnit\Framework\TestCase;

final class API_Handler_Test extends TestCase
{
    public function test_constructor(): void
    {
        $target_url = "http://www.google.com";
        $api_handler = new API_Handler($target_url);

        $target_url_processed = $api_handler->get_target_endpoint();

        $this->assertSame($target_url, $target_url_processed);
    }
}