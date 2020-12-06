<?php


namespace Unit;


use App\Services\Formatters\NumberToLetter;
use TestCase;

class NumberToLetterFormatterTest extends TestCase
{
    protected NumberToLetter $formatter;

    protected function setUp(): void
    {
        parent::setUp();

        $this->formatter = new NumberToLetter();
    }

    /**
    * @test
    */
    public function it_converts_negative_input_to_positive()
    {
        $this->assertSame('A', $this->formatter->format(-1));
    }

    /**
     * @test
     */
    public function it_returns_null_for_zero()
    {
        $this->assertNull($this->formatter->format(0));
    }

    /**
     * @test
     */
    public function it_formats_single_letter()
    {
        $this->assertSame('A', $this->formatter->format(1));
    }

    /**
     * @test
     */
    public function it_formats_double_letters()
    {
        $this->assertSame('AB', $this->formatter->format(28));
    }
}
