<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator;

	use Translator\TranslatorInterface;

	class GoogleTranslate implements TranslatorInterface{
		const API_URL = 'https://www.googleapis.com/language/translate/v2?key={API_KEY}&source={ORIGNAL_LANG}&target={NEW_LANG}&q={STRING}';

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
		public function __construct( $apiKey ){
			$this->apiKey = $apiKey;
		}

		/**
		 * Translate a string from a language to another language
		 * Use the constants of \Translator\Languages to param $originalLang and $newLang
		 *
		 * @param integer $originLang
		 * @param integer $newLang
		 * @param string  $text
		 * @return string
		*/
		public function translate( $originalLang, $newLang, $text ){
			$json = $this->getJsonFromApi( $originalLang, $newLang, $text );
			return $json->translations->translatedText;
		}

		/**
		 * @param integer $originLang
		 * @param integer $newLang
		 * @param string  $text
		 * @return object|array
		*/
		private function getJsonFromApi( $originalLang, $newLang, $text ){
			$originalLang = $this->langs[ $originalLang ];
			$newLang = $this->langs[ $newLang ];

			$urlVars = array(
				'{API_KEY}' => $this->apiKey,
				'{ORIGNAL_LANG}' => $originalLang,
				'{NEW_LANG}' => $newLang,
				'{STRING}' => $text
			);

			$url = str_replace( array_keys( $urlVars ), array_values( $urlVars ), self::API_URL );

			$jsonStr = file_get_contents( $url );
			$json = json_decode( $jsonStr );

			return $json;
		}
	}