<?php
namespace Test\Translator;

use Translator\Translated;

/**
 * @coversDefaultClass Translator\Translated
 */
class TranslatedTest extends \PHPUnit_Framework_TestCase
{
    /**
     * @test
     * @covers ::__construct
     */
    public function constructMustConfigureStringAttributes()
    {
        $originalText = 'hi';
        $newText = 'olá';
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertAttributeSame($originalText, 'originalText', $translated);
        $this->assertAttributeSame($newText, 'newText', $translated);
        $this->assertAttributeSame($originalLang, 'originalLang', $translated);
        $this->assertAttributeSame($newLang, 'newLang', $translated);
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getOriginalText
     */
    public function getOriginalTextShouldReturnCurrentStringConfiguration()
    {
        $originalText = 'hi';
        $newText = 'olá';
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertEquals($originalText, $translated->getOriginalText());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getNewText
     */
    public function getNewTextShouldReturnCurrentStringConfiguration()
    {
        $originalText = 'hi';
        $newText = 'olá';
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertEquals($newText, $translated->getNewText());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getNewText
     */
    public function getNewTextShouldReturnCurrentArrayConfiguration()
    {
        $originalText = 'hi';
        $newText = ['olá', 'hello'];
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertEquals($newText, $translated->getNewText());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getOriginalLang
     */
    public function getOriginalLangShouldReturnCurrentStringConfiguration()
    {
        $originalText = 'hi';
        $newText = 'olá';
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertEquals($originalLang, $translated->getOriginalLang());
    }

    /**
     * @test
     * @covers ::__construct
     * @covers ::getNewLang
     */
    public function getNewLangShouldReturnCurrentStringConfiguration()
    {
        $originalText = 'hi';
        $newText = 'olá';
        $originalLang = 'en';
        $newLang = 'pt';
        $translated = new Translated($originalText, $newText, $originalLang, $newLang);

        $this->assertEquals($newLang, $translated->getNewLang());
    }
}
