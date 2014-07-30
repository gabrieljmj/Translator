<?php
namespace Test\Translator;

use Translator\Detected;

/**
 * @coversDefaultClass Translator\Detected
 */
class DetectedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers ::__construct
     */
    public function constructMustConfigureStringAttributes()
    {
        $text = 'hi';
        $language = 'en';
        $detected = new Detected($text, $language);

        $this->assertAttributeSame($text, 'text', $detected);
        $this->assertAttributeSame($language, 'lang', $detected);
    }

    /**
     * @test
     * @covers ::__construct
     */
    public function constructMustConfigureArrayAttributes()
    {
        $text = ['hi', 'olá'];
        $language = ['en', 'pt'];
        $detected = new Detected($text, $language);

        $this->assertAttributeSame($text, 'text', $detected);
        $this->assertAttributeSame($language, 'lang', $detected);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getText
     */
    public function getTextShouldReturnCurrentStringConfiguration()
    {
        $text = 'hi';
        $language = 'en';
        $detected = new Detected($text, $language);

        $this->assertEquals($text, $detected->getText());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getText
     */
    public function getTextShouldReturnCurrentArrayConfiguration()
    {
        $text = ['hi', 'olá'];
        $language = ['en', 'pt'];
        $detected = new Detected($text, $language);

        $this->assertEquals($text, $detected->getText());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getLang
     */
    public function getLangShouldReturnCurrentStringConfiguration()
    {
        $text = 'hi';
        $language = 'en';
        $detected = new Detected($text, $language);

        $this->assertEquals($language, $detected->getLang());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getLang
     */
    public function getLangShouldReturnCurrentArrayConfiguration()
    {
        $text = ['hi', 'olá'];
        $language = ['en', 'pt'];
        $detected = new Detected($text, $language);

        $this->assertEquals($language, $detected->getLang());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getDetectedTextWithLang
     */
    public function getDetectedTextWithLangShouldReturnCombinedArray()
    {
        $text = ['hi', 'olá'];
        $language = ['en', 'pt'];
        $detected = new Detected($text, $language);

        $this->assertEquals(['hi' => 'en', 'olá' => 'pt'], $detected->getDetectedTextWithLang());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getDetectedTextWithLang
     */
    public function getDetectedTextWithLangShouldReturnCombinedString()
    {
        $text = 'hi';
        $language = 'en';
        $detected = new Detected($text, $language);

        $this->assertEquals(['hi' => 'en'], $detected->getDetectedTextWithLang());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getDetectedTextWithLang
     * @expectedException Exception
     */
    public function getDetectedTextWithLangShouldRaiseExceptionWhenCantCombineConfiguration()
    {
        $text = ['hi', 'hello'];
        $language = 'en';
        $detected = new Detected($text, $language);

        $detected->getDetectedTextWithLang();
    }
}
