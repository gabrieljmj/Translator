<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator;

	use Translator\TranslatedTextInfoInterface;

	class Detected implements DetectedLanguageInfoInterface{
		/**
		 * Text(s) to detected that language
		 *
		 * @var string|array
		*/
		private $text;

		/**
		 * Language of text
		 *
		 * @var string|array
		*/
		private $lang;

		/**
		 * @param string|array
		 * @param string|array
		*/
		public function __construct( $text, $lang ){
			$this->text = $text;
			$this->lang = $lang;
		}

		/**
		 * @return string|array
		*/
		public function getText(){
			return $this->text;
		}

		/**
		 * @return string|array
		*/
		public function getLang(){
			return $this->lang;
		}

		/**
		 * @return array
		*/
		public function getDetectedTextWithLang(){
			$arr = array();

			if( is_array( $this->text ) ){
				$arr = array_combine( $this->text, $this->lang );
			}else{
				$arr[ $this->text ] = $this->lang;
			}

			return $arr;
		}
	}