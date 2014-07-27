<?php
	namespace Test\Translator;

	use \PHPUnit_Framework_TestCase;
	use Translator\Http\Request;
	use Translator\TranslatedTextInfoInterface;
	use Translator\DetectedLanguageInfoInterface;

	abstract class AbstractTranslatorTests extends PHPUnit_Framework_TestCase{
		private $request;

		protected function setUp(){
			$this->request = new Request();
		}

		public function assertPreConditions(){
			$this->assertTrue( class_exists( get_class( $this->getTranslator() ) ) );
		}

		public function testTranslation(){
			$originalText = 'Oi';
			$newText = 'Hi';

			$translation = $this->getTranslator()->translate( 'pt', 'en', $originalText );
			$this->assertEquals( 'pt', $translation->getOriginalLang() );
			$this->assertEquals( 'en', $translation->getNewLang() );
			$this->assertEquals( $originalText, $translation->getOriginalText() );
			$this->assertEquals( $newText, $translation->getNewText() );
		}

		public function testTranslationWithArray(){
			$originalText = array( 'Oi', 'Tchau' );
			$newText = array( 'Hi', 'Bye' );

			$translation = $this->getTranslator()->translate( 'pt', 'en', $originalText );
			$this->assertEquals( 'pt', $translation->getOriginalLang() );
			$this->assertEquals( 'en', $translation->getNewLang() );
			$this->assertEquals( $originalText, $translation->getOriginalText() );
			$this->assertEquals( $newText, $translation->getNewText() );
		}

		public function testLanguageDetection(){
			$detection = $this->getTranslator()->detect( 'Olá' );
			$this->assertEquals( 'Olá!', $detection->getText() );
			$this->assertEquals( 'pt', $detection->getLang() );
			$this->assertEquals( array( 'Olá!' => 'pt' ), $detection->getDetectedTextWithLang() );
		}

		public function testLanguageDetectionWithArray(){
			$texts = array( 'hi', 'olá' );

			$detection = $this->getTranslator()->detect( $texts );
			$this->assertEquals( $texts, $detection->getText() );
			$this->assertEquals( array( 'en', 'pt' ), $detection->getLang() );
			$this->assertEquals( array( 'hi' => 'en', 'Olá!' => 'pt' ), $detection->getDetectedTextWithLang() );
		}

		abstract protected function getTranslator();
	}