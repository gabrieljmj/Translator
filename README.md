Translator
==========
[![Total Downloads](https://poser.pugx.org/gabrieljmj/translator/downloads.png)](https://packagist.org/packages/gabrieljmj/translator) [![Latest Unstable Version](https://poser.pugx.org/gabrieljmj/translator/v/unstable.png)](https://packagist.org/packages/gabrieljmj/translator) [![License](https://poser.pugx.org/gabrieljmj/translator/license.png)](https://packagist.org/packages/gabrieljmj/translator) [![Scrutinizer Code Quality](https://scrutinizer-ci.com/g/GabrielJMJ/Translator/badges/quality-score.png?b=master)](https://scrutinizer-ci.com/g/GabrielJMJ/Translator/?branch=master)

Translator to texts using Web Services or other things that can do this action.
##Install
###Composer
```json
{
  "require": {
    "gabrieljmj/translator": "dev-master"
  }
}
```
##Needs
* [cURL extension](http://php.net/manual/pt_BR/book.curl.php) to do the web services requests.

##Support
###Google Translate - Not tested
  To use the Google Translate, it is necessary an API Key. To create one, follow this steps:
  * Go to the [Google Developers Console](https://console.developers.google.com/).
  * Select a project, or create a new one.
  * In the sidebar on the left, select **APIs & auth**. In the list of APIs, make sure the status is **ON** for the Google Translate API.
  * In the sidebar on the left, select **Credentials**.

  **How to instance:** ```new \Translator\Service\GoogleTranslate( Request $request, string $apiKey )```

###Yandex Translate - Tested
  To use, also is necessary an API Key.
  * Go to [API key request form](http://api.yandex.com/key/form.xml?service=trnsl).
  * After create, go to [My keys](http://api.yandex.com/key/keyslist.xml).
  
  **How to instance:** ```new \Translator\Service\YandexTranslate( Request $request, string $apiKey )```

##How to use
Examples with Google Translate
###Getting accepted languages of a web service
Use the method ```getAcceptedLangs()```. It will return an array with all languages accepted by web service that you are using.

###Translating
```php
use Translator\Service\GoogleTranslate;
use Translator\Http\Request;

$text = 'Hi! How are you?';
$apiKey = 'YOUR_API_KEY';

$translator = new GoogleTranslate( new Request(), $apiKey );
$translatedText = $translator->translate( 'en', 'pt', $text );
$translatedText->getNewText();//'Oi! Como vai você?'
$translatedText->getOriginalText();//'Hi! How are you?'
$translatedText->getOriginalLang();//en
$translatedText->getNewLang();//pt
```
With an array:
```php
$texts = array( 'Hi!', 'How are you?' );

$translatedText = $translator->translate( 'en', 'pt', $texts );
$translatedText->getNewText();//Array( 'Oi!', 'Como vai você?' )
$translatedText->getOriginalText();//Array( 'Hi!', 'How are you?' )
$translatedText->getOriginalLang();//en
$translatedText->getNewLang();//pt
```
###Detecting
```php
$detectedText = $translator->detect( $text );
$detectedText->getLang();//en
$detectedText->getText()//Hi! How are you?
$detectedText->getDetectedTextWithLang();//Array( 'Hi! How are you?' => 'en' )
```
With an array:
```php
$texts = array( 'Hi!', 'Olá!' );

$detectedText = $translator->detect( $texts );
$detectedText->getLang();//Array( 'en', 'pt' )
$detectedText->getText();//Array( 'Hi!', 'Olá!' )
$detectedText->getDetectedTextWithLang();//Array( 'Hi!' => 'en', 'Olá!' => 'pt' )
```
