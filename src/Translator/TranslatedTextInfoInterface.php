<?php
/**
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
*/

namespace Translator;

interface TranslatedTextInfoInterface
{
    /**
     * @return string|array
    */
    public function getOriginalText();

    /**
     * @return string|array
    */
    public function getNewText();

    /**
     * @return string
    */
    public function getOriginalLang();

    /**
     * @return string
    */
    public function getNewLang();
}
