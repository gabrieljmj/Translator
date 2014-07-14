<?php
	namespace Test\Translator;

	use \PHPUnit_Framework_TestCase;
	use Translator\Languages;
	use Translator\Service\GoogleTranslate;

	class GoogleTranslateTests extends PHPUnit_Framework_TestCase{
		public function assertPreConditions(){
			$this->assertTrue( class_exists( 'Translator\Service\GoogleTranslate' ) );
		}

		public function testTranslation(){
			$originalText = 'Oi';
			$newText = 'Hi';
			$apiKey = 'YOUR_VALID_API_KEY';

			$translator = new GoogleTranslate( $apiKey );
			$translation = $translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, $originalText );
			$this->assertEquals( $newText, $translation );
		}

		/**
		 * @exceptedException Translator\Exception\TranslatorException
		*/
		public function testExceptionWithInvalidApiKey(){
			$translator = new GoogleTranslate( '[INVALID API KEY]' );
			$translation = $translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, 'Oi' );
		}
	}