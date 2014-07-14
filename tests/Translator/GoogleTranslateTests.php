<?php
	namespace Test\Translator;

	use \PHPUnit_Framework_TestCase;
	use Translator\Languages;
	use Translator\Service\GoogleTranslate;
	use Translator\Http\Request;

	class GoogleTranslateTests extends PHPUnit_Framework_TestCase{
		private $request;
		private $translator;

		protected function setUp(){
			$this->request = new Request();
			$this->translator = new GoogleTranslate( $this->request, 'YOUR_VALID_API_KEY' );
		}

		public function assertPreConditions(){
			$this->assertTrue( class_exists( 'Translator\Service\GoogleTranslate' ) );
		}

		public function testTranslation(){
			$originalText = 'Oi';
			$newText = 'Hi';

			$translation = $this->translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, $originalText );
			$this->assertEquals( $newText, $translation );
		}

		public function testTranslationWithArray(){
			$originalText = array( 'Oi', 'Tchau' );
			$newText = array( 'Hi', 'Bye' );

			$translation = $this->translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, $originalText );
			$this->assertEquals( $newText, $translation );
		}

		/**
		 * @exceptedException Translator\Exception\TranslatorException
		*/
		public function testExceptionWithInvalidApiKey(){
			$translator = new GoogleTranslate( $this->request, '[INVALID API KEY]' );
			$translation = $translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, 'Oi' );
		}

		public function testLanguageDetection(){
			$detection = $this->translator->detect( 'Olá' );
			$this->assertEquals( 'pt', $detection );
		}
	}