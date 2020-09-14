# TrelloAPI

Simple class for making requests to the Trello API.  Not affiliated with Trello or Atlassian.


## Usage

```php
use cjrasmussen\TrelloAPI;

$trello = new TrelloAPI($key, $token);

// GET THE CARD DATA FOR A SPECIFIED LIST
$data = $trello->request('GET', "/1/lists/{$list_id}}/cards");

// MARK A SPECIFIED CARD AS ARCHIVED
$trello->request('PUT', "/1/cards/{$card_id}/closed", ['value' => true]);
```

## More Examples

More examples, as well as other things I've learned using the Trello API, are [available at my blog](https://blog.cjr.dev/tag/trello-automation/).

## Installation

Simply add a dependency on cjrasmussen/TrelloAPI to your composer.json file if you use [Composer](https://getcomposer.org/) to manage the dependencies of your project:

```sh
composer require cjrasmussen/TrelloAPI
```

Although it's recommended to use Composer, you can actually include the file(s) any way you want.


## License

Minify is [MIT](http://opensource.org/licenses/MIT) licensed.