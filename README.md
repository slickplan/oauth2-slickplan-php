# [Slickplan](https://slickplan.com) Provider for OAuth 2.0 Client

This package provides Slickplan OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

## Installation

To install, use composer:

```
composer require slickplan/oauth2-slickplan-php
```

## Usage

Usage is the same as The League's OAuth client, using `\Slickplan\OAuth2\Client\Provider\Slickplan` as the provider.

Please see [thephpleague/oauth2-client](https://oauth2-client.thephpleague.com/usage/) for instruction.

Example code:

```php
use Slickplan\OAuth2\Client\Provider\Slickplan as SlickplanProvider;

$provider = new SlickplanProvider([
    'clientId' => '{client-id}',
    'clientSecret' => '{client-secret}',
    'redirectUri' => 'https://example.com/slickplan/redirect-uri/',
]);

if (isset($_GET['error'])) {
    exit('Error: ' . $_GET['error'] . (isset($_GET['error_description']) ? ' (' . $_GET['error_description'] . ')' : ''));
} elseif (!isset($_GET['code'])) {
    header('Location: ' . $provider->getAuthorizationUrl(['scope' => 'all_read']));
    exit;
}

try {
    $token = $provider->getAccessToken('authorization_code', [
        'code' => $_GET['code'],
    ]);
    $user = $provider->getResourceOwner($token);
} catch (Exception $e) {
    exit('Error: ' . $e->getMessage());
}

echo 'Hello ' . $user->getFirstName() . '!<br>';
echo 'Your API token: <code>' . $token->getToken() . '</code>';
```
