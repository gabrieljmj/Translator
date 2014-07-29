<?php
namespace Test\Translator;

use Test\Translator\AbstractTranslatorTests;
use Translator\Service\GoogleTranslate;

class GoogleTranslateTests extends AbstractTranslatorTests
{
    protected function getTranslator()
    {
        return new GoogleTranslate($this->request, 'YOUR_API_KEY');
    }
}
