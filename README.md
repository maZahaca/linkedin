LinkedIn API with caching
========
This library implements ability of caching all requests to LinkedIn API.

## Installation ##
- Add to you composer.json file the line:
```json
"redcode/linkedin-api": "*",
```
- Update composer with command:
```shell
composer update redcode/linkedin-api
```

## Usage ##

```php
// lifeTime of cache in seconds
$lifeTimeInSeconds  = 60 * 60;

// any writable dir
$cacheDir           = '',

$api = new RedCode\LinkedIn\LinkedIn([
       'api_key'       => '',
       'api_secret'    => '',
       'callback_url'  => ''
    ],
    new Cache\FilesystemCache($cacheDir),
    $lifeTimeInSeconds
);
```
