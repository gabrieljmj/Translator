<?php
	namespace Translator\Service;

	use Translator\Service\AbstractTranslatorWebService;
	use Translator\Exception\TranslatorException;
	use Translator\Translated;
	use Translator\Detected;
	use Translator\Http\Request;

	class YandexTranslate extends AbstractTranslatorWebService{
		const API_URL = 'https://translate.yandex.net/api/v1.5/tr.json';

		/**
		 * API Key for use Yandex
		 *
		 * @var string
		*/
		private $apiKey;

		/**
		 * All languages accepted by Yandex
		 *
		 * @var array
		*/
		private $langs = array();

		/**
		 * @param \Translator\Http\Request $request
		 * @param string                   $apiKey
		*/
		public function __construct( Request $request, $apiKey ){
			parent::__construct( $request );
			$this->apiKey = $apiKey;
			$this->setLangs();
		}

		/**
		 * Translate a string from a language to another language
		 * Use the constants of \Translator\Languages to param $originalLang and $newLang
		 *
		 * @param integer       $originLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return string|array
		*/
		public function translate( $originalLang, $newLang, $text ){
			$return = $this->getTranslateFromApi( $originalLang, $newLang, $text );
			$this->verifyErrorAndThrowAnException( $return );

			$translatedText = ( is_array( $text ) ) ? $return->text : $return->text[0];

			return new Translated( $text, $translatedText, $originalLang, $newLang );
		}

		/**
		 * Detect the language of one or more texts
		 *
		 * @param string|array $text
		 * @return string
		*/
		public function detect( $text ){
			$return = $this->getDetectionFromApi( $text );

			if( is_array( $return ) ){
				$langs = array();

				foreach( $return as $detection ){
					$this->verifyErrorAndThrowAnException( $detection );

					$langs[] = $detection->lang;
				}

				return new Detected( $text, $langs );
			}

			return new Detected( $text, $return->lang );
		}

		/**
		 * Get all languages accepted on API
		 *
		 * @return array
		*/
		public function getAcceptedLangs(){
			return $this->langs;
		}

		/**
		 * Updates with all accepted languages
		*/
		private function setLangs(){
			$url = self::API_URL . '/getLangs';
			$return = json_decode( $this->request->send( $url, array( 'key' => $this->apiKey, 'ui' => 'en' ) ) );
			$this->verifyErrorAndThrowAnException( $return );

			$langs = get_object_vars( $return->langs );
			$this->langs = array_keys( $langs );
		}

		/**
		 * @param integer       $originLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return object
		*/
		private function getTranslateFromApi( $originalLang, $newLang, $text ){
			$params = array(
				'key' => $this->apiKey,
				'lang' => $originalLang . '-' . $newLang
			);

			$textParam = $this->constructTextParam( 'text', $text );
			$url = self::API_URL . '/translate?' . http_build_query( $params ) . '&' . $textParam;
			return json_decode( $this->request->send( $url ) );
		}

		/**
		 * @param string|array $text
		 * @return string
		*/
		private function getDetectionFromApi( $text ){
			if( is_array( $text ) ){
				$detections = array();

				foreach( $text as $textOne ){
					$textOne = urlencode( $textOne );
					$textParam = $this->constructTextParam( 'text', $textOne );
					$url = self::API_URL . '/detect?' . http_build_query( array( 'key' => $this->apiKey ) ) . '&' . $textParam;

					$detections[] = json_decode( $this->request->send( $url ) );
				}

				return $detections;
			}

			$textParam = $this->constructTextParam( 'text', $text );
			$url = self::API_URL . '/detect?' . http_build_query( array( 'key' => $this->apiKey ) ) . '&' . $textParam;

			return json_decode( $this->request->send( $url ) );
		}

		/**
		 * @var array|object $json
		*/
		private function verifyErrorAndThrowAnException( $json ){
			if( isset( $json->message ) ){
				throw new TranslatorException( 'Yandex Translator returns: ' . $json->message . ' (' . $json->code . ')' );
			}
		}
	}