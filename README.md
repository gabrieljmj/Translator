Translator
==========
[![Total Downloads](https://poser.pugx.org/gabrieljmj/translator/downloads.png)](https://packagist.org/packages/gabrieljmj/translator) [![Latest Unstable Version](https://poser.pugx.org/gabrieljmj/translator/v/unstable.png)](https://packagist.org/packages/gabrieljmj/translator) [![License](https://poser.pugx.org/gabrieljmj/translator/license.png)](https://packagist.org/packages/gabrieljmj/translator)

Translator to strings using Web Services or another things
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

##How to use
###Google Translate
To use the Google Translate, it is necessary an API Key. To create one, follow this steps:
* Go to the [Google Developers Console](https://console.developers.google.com/).
* Select a project, or create a new one.
* In the sidebar on the left, select **APIs & auth**. In the list of APIs, make sure the status is **ON** for the Google Translate API.
* In the sidebar on the left, select **Credentials**.

###Translating
```php
use Translator\Service\GoogleTranslate;
use Translator\Http\Request;
use Translator\Languages;

$text = 'Hi! How are you?';
$apiKey = 'YOU_API_KEY';

$translator = new GoogleTranslate( new Request(), $apiKey );
$translatedText = $translator->translate( Languages::ENGLISH, Languages::PORTUGUESE, $text );
//Oi! Como vai você?
```
With array:
```php
$texts = array( 'Hi!', 'How are you?' );

$translatedText = $translator->translate( Languages::ENGLISH, Languages::PORTUGUESE, $texts );
//Array(
//  'Oi!',
//  'Como vai você?'
//)
```
