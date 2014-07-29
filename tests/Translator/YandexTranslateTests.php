<?php
namespace Test\Translator;

use Test\Translator\AbstractTranslatorTests;
use Translator\Service\YandexTranslate;

class YandexTranslateTests extends AbstractTranslatorTests
{
    protected function getTranslator()
    {
        return new YandexTranslate($this->request, 'YOUR_API_KEY');
    }
}
