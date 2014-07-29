<?php
/**
 * @author Gabriel Jacinto <gamjj74@hotmail.com>
 * @license MIT License
*/

namespace Translator\Service;

use Translator\Service\AbstractTranslatorWebService;
use Translator\Exception\TranslatorException;
use Translator\Http\RequestInterface;
use Translator\Translated;
use Translator\Detected;

class GoogleTranslate extends AbstractTranslatorWebService
{
    const API_URL = 'https://www.googleapis.com/language/translate/v2';

    /**
     * Languages list
     *
     * @var array
    */
    private $langs;

    /**
     * A key used to Google APIs
     *
     * @var string
    */
    private $apiKey;

    /**
     * @param string $apiKey
    */
    public function __construct(RequestInterface $request, $apiKey)
    {
        parent::__construct($request);
        $this->apiKey = $apiKey;
        $this->setLangs();
    }

    /**
     * Returns all accepted languages by service
     *
     * @return array
    */
    public function getAcceptedLangs()
    {
        return $this->langs;
    }

    /**
     * Updates with all accepted languages
    */
    private function setLangs()
    {
        $url = self::API_URL . '/languages';

        $return = $this->request->send($url, array('key' => $this->apiKey));
        $json = json_decode($return);
        $this->verifyErrorAndThrowAnException($json);

        foreach ($json->data->languages as $lang) {
            $this->langs[] = $lang->language;
        }
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
    public function translate($originalLang, $newLang, $text)
    {
        $json = $this->getTranslationFromApi($originalLang, $newLang, $text);
        $this->verifyErrorAndThrowAnException($json);

        if (count($json->translations) > 1) {
            $return = array();

            foreach ($json->translations as $translation) {
                $return[] = $translation->translatedText;
            }

            return new Translated($text, $return, $originalLang, $newLang);
        }

        return new Translated($text, $json->translations[0]->translatedText, $originalLang, $newLang);
    }

    /**
     * Detect the language of one or more texts
     *
     * @param string|array $text
     * @return string|array
    */
    public function detect($text)
    {
        $detection = $this->getDetectionFromApi($text);

        if (is_array($detection->data->detections)) {
            $return = array();

            foreach ($detection->data->detections as $d) {
                foreach ($d as $d2) {
                    $return[] = $d2->language;
                }
            }

            return new Detected($text, $return);
        }

        return new Detected($text, $detection->data->detections[0][0]->language);
    }

    /**
     * @param integer       $originalLang
     * @param integer       $newLang
     * @param string|array  $text
     * @return object|array
    */
    private function getTranslationFromApi($originalLang, $newLang, $text)
    {
        $getParams = array(
            'key' => $this->apiKey,
            'source' => $originalLang,
            'target' => $newLang
        );

        $qParam = $this->constructTextParam('q', $text);

        $url = self::API_URL . '?' . http_build_query($getParams) . '&' . $qParam;

        return json_decode($this->request->send($url));
    }

    /**
     * @param string|array
     * @return object|array
    */
    private function getDetectionFromApi($text)
    {
        $qParam = $this->constructTextParam('q', $text);

        $url = self::API_URL . '/detect?key=' . $this->apiKey . '&' . $qParam;

        return json_decode($this->request->send($url));
    }

    private function verifyErrorAndThrowAnException($json)
    {
        $message = $json->error->message;
        $code = $json->error->code;

        if (isset($json->error)) {
            throw new TranslatorException('Google Translate returns: ' . $message . ' (' . $code . ')');
        }
    }
}
