<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/
	
	namespace Translator;

	interface TranslatorInterface{
		/**
		 * Translate a string from a language to another language
		 * Use the constants of \Translator\Languages to param $originalLang and $newLang
		 *
		 * @param integer       $originLang
		 * @param integer       $newLang
		 * @param string|array  $text
		 * @return string
		*/
		public function translate( $originalLang, $newLang, $text );

		/**
		 * Detect the language of one or more texts
		 *
		 * @param string|array $text
		 * @return string
		*/
		public function detect( $text );
	}