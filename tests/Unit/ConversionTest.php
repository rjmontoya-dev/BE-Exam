<?php

namespace Tests\Unit;

use App\Services\CurrencyService;
use PHPUnit\Framework\TestCase;

class ConversionTest extends TestCase
{
    /**
     * A basic unit test example.
     */
    public function test_example(): void
    {
        $this->assertTrue(true);
    }
    public function test_price_attribute(){
        $converted = new CurrencyService();
        $conversion =  $converted->convert(00,"asdf","asdf");
        $this->assertEquals('hello',$conversion);
    }
}
