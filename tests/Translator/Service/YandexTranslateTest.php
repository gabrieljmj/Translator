<?php
namespace Test\Translator\Service;

use Translator\Http\CurlRequest;
use Translator\Service\YandexTranslate;

class YandexTranslateTests extends AbstractTranslatorTest
{
    protected function getTranslator(CurlRequest $request)
    {
        return new YandexTranslate($request, 'YOUR_API_KEY');
    }
}
