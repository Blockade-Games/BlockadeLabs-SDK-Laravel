# Blockade Labs SDK for Laravel

## Laravel Versions Support

- \>= 7.0

## Installation

You can install the package via composer:

```bash
composer require blockadelabs/sdk
```

## Getting Started

Before you are able to use the SDK, you need to edit your `.env` file and add your Blockade Labs API key:

`BLOCKADE_LABS_API_KEY=YOUR_API_KEY`

Package will register a Facade that you can use in your app to make API calls, just make sure to include it
at the top of the file:

```php
use BlockadeLabs\SDK\Facades\BlockadeLabsClient;
```

## Usage

All the methods and routes are also explained (in greater detail) in the Docs
<a href="https://api-documentation.blockadelabs.com/" target="_blank">here.</a>

### Skyboxes

#### getSkyboxStyles

```php
$skyboxStyles = BlockadeLabsClient::getSkyboxStyles();
```

#### generateSkybox

```php
$skybox = BlockadeLabsClient::generateSkybox([
   'prompt' => 'PROMPT_GOES_HERE', // Required
   'skybox_style_id' => '2', // Required,
   'remix_imagine_id' => 1, // OR remix_obfuscated_id / Optional
   'webhook_url' => 'YOUR_WEBHOOK_URL', // Optional
]);
```

You can refer to the docs
<a href="https://api-documentation.blockadelabs.com/api/skybox.html#generate-skybox" target="_blank">here</a>
and <a href="https://api-documentation.blockadelabs.com/api/skybox.html#generate-skybox-remix" target="_blank">here</a>
for more details on how to generate new skyboxes and how to generate skyboxes that are remixes of previously generated skyboxes.

### Imagine Requests

#### getGenerators

```php
$generators = BlockadeLabsClient::getGenerators();
```

#### generateImagine

```php
$generateImagine = BlockadeLabsClient::generateImagine([
    'generator' => 'stable-skybox', // REQUIRED
    'prompt' => 'PROMPT_GOES_HERE', // REQUIRED
    'init_image' => $request->file('init_image') // example for the init_image file param
    ...other_generator_data_params, // Optional
    'webhook_url' => 'YOUR_WEBHOOK_URL', // Optional
]);
```

You can refer to the docs 
<a href="https://api-documentation.blockadelabs.com/api/imagine-request.html#get-generators" target="_blank">here</a> 
and <a href="https://api-documentation.blockadelabs.com/api/imagine-request.html#generate-imagine" target="_blank">here</a>
on how to get and use generator data when generating imagines.

The `generateImagine` method can accept different types of generator data, which may include files.

When sending files it's enough to just pass the file from the request, like so:

```php
'init_image' => $request->file('init_image'),
```

#### getImagineById

```php
$generateImagine = BlockadeLabsClient::generateImagine([
    'generator' => 'stable-skybox',
    'prompt' => 'some prompt',
]);

$imagine = BlockadeLabsClient::getImagineById($generateImagine['request']['id']);
```

#### getImagineByObfuscatedId

```php
$generateImagine = BlockadeLabsClient::generateImagine([
    'generator' => 'stable-skybox',
    'prompt' => 'some prompt',
]);

$imagine = BlockadeLabsClient::getImagineByObfuscatedId($generateImagine['request']['obfuscated_id']);
```

#### getImagineHistory

```php
$myImagines = BlockadeLabsClient::getImagineHistory([
    'status' => 'IMAGINE_STATUS', // OPTIONAL
    'limit' => 10, // OPTIONAL
    'offset' => 0, // OPTIONAL
    'order' => 'ASC', // OPTIONAL
    'imagine_id' => 1, // OPTIONAL
    'query' => 'PROMPT', // OPTIONAL
    'generator' => 'GENERATOR', // OPTIONAL
]);
```

#### cancelImagine

```php
$generateImagine = BlockadeLabsClient::generateImagine([
    'generator' => 'stable-skybox',
    'prompt' => 'some prompt',
]);

$result = BlockadeLabsClient::cancelImagine($generateImagine['request']['id']);
```

#### cancelAllPendingImagines

```php
$result = BlockadeLabsClient::cancelAllPendingImagines();
```

#### deleteImagine

```php
$generateImagine = BlockadeLabsClient::generateImagine([
    'generator' => 'stable-skybox',
    'prompt' => 'some prompt',
]);

$result = BlockadeLabsClient::deleteImagine($generateImagine['request']['id']);
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.
