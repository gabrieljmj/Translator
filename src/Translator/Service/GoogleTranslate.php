<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator\Service;

	use Translator\TranslatorInterface;
	use Translator\Exception\TranslatorException;
	use Translator\Http\Request;

	class GoogleTranslate extends AbstractTranslatorWebService{
		const API_URL = 'https://www.googleapis.com/language/translate/v2';

		/**
		 * Languages list
		 *
		 * @var array
		*/
		private $langs = array(
			1 => 'af',
				 'sq',
				 'ar',
				 'az',
				 'eu',
				 'Bbn',
				 'be',
				 'bg',
				 'ca',
				 'zh-CN',
				 'zh-TW',
				 'hr',
				 'cs',
				 'da',
				 'nl',
				 'en',
				 'eo',
				 'et',
				 'tl',
				 'fi',
				 'fr',
				 'gl',
				 'ka',
				 'de',
				 'el',
				 'gu',
				 'ht',
				 'iw',
				 'hi',
				 'hu',
				 'is',
				 'id',
				 'ga',
				 'it',
				 'ja',
				 'kn',
				 'ko',
				 'la',
				 'lv',
				 'lt',
				 'mk',
				 'ms',
				 'mt',
				 'no',
				 'fa',
				 'pl',
				 'pt',
				 'ro',
				 'ru',
				 'sr',
				 'sk',
				 'sl',
				 'es',
				 'sw',
				 'sv',
				 'ta',
				 'te',
				 'th',
				 'tr',
				 'uk',
				 'ur',
				 'vi',
				 'cy',
				 'yi'
		);

		/**
		 * A key used to Google APIs
		 *
		 * @var string
		*/
		private $apiKey;

		/**
		 * @param string $apiKey
		*/
		public function __construct( Request $request, $apiKey ){
			parent::__construct( $request );
			$this->apiKey = $apiKey;
		}

		/**
		 * Translate a string from a language to another language
		 * Use the constants of \Translator\Languages to param $originalLang and $newLang
		 *
		 * @param integer       $originLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return string
		*/
		public function translate( $originalLang, $newLang, $text ){
			$json = $this->getJsonFromApi( $originalLang, $newLang, $text );

			if( isset( $json->error ) ){
				throw new TranslatorException( 'Google Translate returns: ' . $json->error->message . ' (' . $json->error->code . ')' );
			}

			if( count( $json->translations ) > 1 ){
				$return = array();

				foreach( $this->translations as $translation ){
					$return[] = $translation->translatedText;
				}

				return $return;
			}

			return $json->translations[0]->translatedText;
		}

		/**
		 * Detect the language of one or more texts
		 *
		 * @param string|array $text
		 * @return string|array
		*/
		public function detect( $text ){
			$detection = $this->getDetectionFromApi( $text );

			if( is_array( $detection->data->detections ) ){
				foreach( $detection->data->detections as $d ){
					foreach( $d as $d2 ){
						$return[] = $d2->language;
					}
				}

				return $return;
			}

			return $detection->data->detections[0][0]->language;
		}

		/**
		 * @param integer       $originalLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return object|array
		*/
		private function getTranslationFromApi( $originalLang, $newLang, $text ){
			$originalLang = $this->langs[ $originalLang ];
			$newLang = $this->langs[ $newLang ];

			$getParams = array(
				'key' => $this->apiKey,
				'from' => $originalLang,
				'to' => $newLang
			);

			$qParam = $this->constructQParam( $text );

			$url = self::API_URL . '?' . http_build_query( $getParams ) . $qParam;

			$return = $this->request->send( $url );
            
			return $return;
		}

		/**
		 * @param string|array
		 * @return object|array
		*/
		private function getDetectionFromApi( $text ){
			$qParam = $this->constructQParam( $text );

			$url = self::API_URL . '/detect?key=' . $this->apiKey . $qParam;

			$return = $this->request->send( $url );

			return $return;
		}

		private function constructQParam( $text ){
			$qParam = null;

			if( is_array( $text ) ){
				foreach( $text as $str ){
					if( !is_string( $str ) ){
						throw new TranslatorException( 'All parameters must be string' );
					}

					$qParam .= '&q=' . $str;
				}
			}else{
				if( !is_string( $text ) ){
					throw new TranslatorException( 'The text must be string' );
				}

				$qParam = '&' . $text;
			}

			return $qParam;
		}
	}