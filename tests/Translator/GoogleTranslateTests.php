<?php
	namespace Test\Translator;

	use \PHPUnit_Framework_TestCase;
	use Translator\Languages;
	use Translator\GoogleTranslate;

	class GoogleTranslateTests extends PHPUnit_Framework_TestCase{
		public function assertPreConditions(){
			$this->assertTrue( class_exists( 'Translator\GoogleTranslate' ) );
		}

		public function testTranslation(){
			$originalText = 'Oi';
			$newText = 'Hi';
			$apiKey = 'API_KEY';

			$translator = new GoogleTranslate( $apiKey );
			$translation = $translator->translate( Languages::PORTUGUESE, Languages::ENGLISH, $originalText );
			$this->assertEquals( $newText, $translator );
		}
	}