<?php
namespace Test\Translator\Service;

use Translator\Http\CurlRequest;
use Translator\Service\GoogleTranslate;

class GoogleTranslateTests extends AbstractTranslatorTest
{
    protected function getTranslator(CurlRequest $request)
    {
        return new GoogleTranslate($request, 'YOUR_API_KEY');
    }
}
