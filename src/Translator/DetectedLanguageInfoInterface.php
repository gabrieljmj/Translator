<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator;

	interface DetectedLanguageInfoInterface
	{
		/**
		 * @return string|array
		*/
		public function getText();

		/**
		 * @return string|array
		*/
		public function getLang();

		/**
		 * @return array
		*/
		public function getDetectedTextWithLang();
	}