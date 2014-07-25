<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/
	
	namespace Translator\Service;

	use Translator\TranslatorInterface;
	use Translator\Http\Request;

	abstract class AbstractTranslatorWebService implements TranslatorInterface{
		/**
		 * Object for HTTP requests
		 *
		 * @var \Translator\Http\Request
		*/
		protected $request;

		/**
		 * @param \Translator\Http\Request $request
		*/
		public function __construct( Request $request ){
			$this->request = $request;
		}

		/**
		 * Construct param with texts cause generally web services accept more than one text
		 *
		 * @param string       $paramName
		 * @param string|array $text
		*/
		protected function constructTextParam( $paramName, $text ){
			$param = null;

			if( is_array( $text ) ){
				foreach( $text as $str ){
					if( !is_string( $str ) ){
						throw new TranslatorException( 'All parameters must be string' );
					}

					$param .= ( !is_null( $param ) ) ? '&' . $paramName . '=' . $str : $paramName . '=' . $str;
				}
			}else{
				if( !is_string( $text ) ){
					throw new TranslatorException( 'The text must be string' );
				}

				$param = $paramName . '=' . $text;
			}

			return $param;
		}
	}