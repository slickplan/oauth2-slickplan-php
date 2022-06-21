# Slickplan Provider for OAuth 2.0 Client

This package provides [Slickplan](https://slickplan.com) OAuth 2.0 support for the PHP League's [OAuth 2.0 Client](https://github.com/thephpleague/oauth2-client).

Slickplan API documentation: [slickplan/api-docs](https://github.com/slickplan/api-docs)

## Installation

To install, use composer:

```
composer require slickplan/oauth2-slickplan-php
```

## Usage

Please refer to [League's Oauth Client documentation](https://oauth2-client.thephpleague.com/usage/).

Example code:

```php
use Slickplan\OAuth2\Client\Provider\Slickplan as SlickplanProvider;

$provider = new SlickplanProvider([
    'clientId' => '{client-id}',
    'clientSecret' => '{client-secret}',
    'redirectUri' => 'https://example.com/slickplan/redirect-uri/',
]);

if (isset($_GET['error'])) {
    print_r($_GET);
    exit;
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
