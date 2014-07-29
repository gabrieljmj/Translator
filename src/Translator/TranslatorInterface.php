<?php
/**
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
*/

namespace Translator;

/**
 * Interface to translators
*/
interface TranslatorInterface
{
    /**
     * Returns all accepted languages by service
     *
     * @return array
    */
    public function getAcceptedLangs();

    /**
     * Translate a string from a language to another language
     * Use the constants of \Translator\Languages to param $originalLang and $newLang
     *
     * @param integer       $originLang
     * @param integer       $newLang
     * @param string|array  $text
     * @return \Translator\TranslatedTextInfoInterface
    */
    public function translate($originalLang, $newLang, $text);

    /**
     * Detect the language of one or more texts
     *
     * @param string|array $text
     * @return \Translator\DetectedLanguageInfoInterface
    */
    public function detect($text);
}
