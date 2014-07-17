<?php
	namespace Translator\Service;

	use Translator\Service\AbstractTranslatorWebService;
	use Translator\Http\Request;

	class MicrosoftTranslator extends AbstractTranslatorWebService{
		const API_URL = 'http://api.microsofttranslator.com/V2/Http.svc/Translate';
		const AUTH_URL = 'https://datamarket.accesscontrol.windows.net/v2/OAuth2-13';

		/**
		 * Client ID
		 *
		 * @var string
		*/
		private $clientId;

		/**
		 * Client Secret ID
		 *
		 * @var string
		*/
		private $secretId;

		/**
		 * All languages
		 *
		 * @var array
		*/
		private $langs = array();

		/**
		 * @param \Translator\Http\Request $request
		 * @param string                   $clientId
		 * @param string                   $secretId
		*/
		public function __construct( Request $request, $clientId, $secretId ){
			parent::__construct( $request );
			$this->clientId = $clientId;
			$this->secretId = $secretId;
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
			$return = $this->getTranslationFromApi( $originalLang, $newLang, $text );
		}

		/**
		 * Detect the language of one or more texts
		 *
		 * @param string|array $text
		 * @return string
		*/
		public function detect( $text ){
			
		}

		/**
		 * @param integer       $originLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return string
		*/
		private function getTranslationFromApi( $originalLang, $newLang, $text ){
			$originalLang = $this->langs[ $originalLang ];
			$newLang = $this->langs[ $newLang ];

			$params = http_build_query( array(
				'from' => $originalLang,
				'to' => $newLang
			) );

			$textParam = $this->getTextParam( $text );

			$url = self::API_URL . '?' . $params . $textParam;
			$accessToken = 'Authorization:bearer ' . $this->getAccessToken();

			$return = $this->request->send( $url, array(), $accessToken );
			return json_decode( $return );
		}

		/**
		 * @return string
		*/
		private function getAccessToken(){
			$params = array(
				'grant_type' => 'client_credentials',
				'client_id' => urlencode( $this->clientId ),
        		'client_secret' => urlencode( $this->secretId ),
        		'scope' => 'http://api.microsofttranslator.com'
			);

			$return = $this->request->send( self::AUTH_URL, $params );
			$json = json_decode( $return );

			return $json->access_token;
		}

		/**
		 * @param string|array
		*/
		private function getTextParam( $text ){
			$qParam = null;

			if( is_array( $text ) ){
				foreach( $text as $str ){
					if( !is_string( $str ) ){
						throw new TranslatorException( 'All parameters must be string' );
					}

					$qParam .= '&text=' . $str;
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