<?php
	namespace Test\Translator;

	use \PHPUnit_Framework_TestCase;
	use Translator\Http\Request;

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
			$this->assertEquals( $newText, $translation );
		}

		public function testTranslationWithArray(){
			$originalText = array( 'Oi', 'Tchau' );
			$newText = array( 'Hi', 'Bye' );

			$translation = $this->getTranslator()->translate( 'pt', 'en', $originalText );
			$this->assertEquals( $newText, $translation );
		}

		/**
		 * @exceptedException Translator\Exception\TranslatorException
		*/
		public function testExceptionWithInvalidApiKey(){
			$translator = new GoogleTranslate( $this->request, '[INVALID API KEY]' );
			$translation = $translator->translate( 'pt', 'en', 'Oi' );
		}

		public function testLanguageDetection(){
			$detection = $this->getTranslator()->detect( 'Olá' );
			$this->assertEquals( 'pt', $detection );
		}

		abstract protected function getTranslator();
	}