GoogleAPIComponent
==================

GoogleAPI Component for CakePHP for accessing of Google Services (initially only Google Translate)


Quickstart for Google Translate
-------

1. Copy the file to /app/Controllers/Components
2. Edit your developer_key in the GoogleAPIComponent.php file.
3. Add the class to your $components in AppController.php:

```php
  class AppController extends Controller {
    public $components = array('GoogleAPI');
  }
```

Then use it anywhere like this to translate your texts:

```php
  $result = $this->GoogleAPI->Translate($source_language, $target_language, $text);
  echo $result['data']['translations'][0]['translatedText'];
```

Texts are cached for a week to prevent unnecessary API calls.
