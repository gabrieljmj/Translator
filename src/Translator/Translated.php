<?php
	/**
	 * @author Gabriel Jacinto <gamjj74@hotmail.com>
	 * @license MIT License
	*/

	namespace Translator;

	use Translator\TranslatedTextInfoInterface;

	class Translated implements TranslatedTextInfoInterface
	{
		/**
		 * Translated text
		 *
		 * @var string|array
		*/
		private $originalText;

		/**
		 * Original text
		 *
		 * @var string|array
		*/
		private $newText;

		/**
		 * Original language of text
		 *
		 * @var string
		*/
		private $originalLang;

		/**
		 * New language of text
		 *
		 * @var string
		*/
		private $newLang;

		/**
		 * @param string|array $text
		 * @param string       $originalLang
		 * @param string       $newLang
		*/
		public function __construct($originalText, $newText, $originalLang, $newLang)
		{
			$this->originalText = $originalText;
			$this->newText = $newText;
			$this->originalLang = $originalLang;
			$this->newLang = $newLang;
		}

		/**
		 * @return string|array
		*/
		public function getOriginalText()
		{
			return $this->originalLang;
		}

		/**
		 * @return string|array
		*/
		public function getNewText()
		{
			return $this->newText;
		}

		/**
		 * @return string
		*/
		public function getOriginalLang()
		{
			return $this->originalLang;
		}

		/**
		 * @return string
		*/
		public function getNewLang()
		{
			return $this->newLang;
		}
	}