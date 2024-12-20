# KUSK Core-PHP

[![Supports Windows](https://img.shields.io/badge/support-Windows-blue?logo=Windows)](https://github.com/KUSK-TOP/kusk-php/releases/latest)
[![Supports Linux](https://img.shields.io/badge/support-Linux-yellow?logo=Linux)](https://github.com/KUSK-TOP/kusk-php/releases/latest)
[![License](https://img.shields.io/github/license/KUSK-TOP/core)](https://github.com/KUSK-TOP/kusk-php/blob/master/LICENSE)
[![Latest Release](https://img.shields.io/github/v/release/KUSK-TOP/core?label=latest%20release)](https://github.com/KUSK-TOP/kusk-php/releases/latest)
[![Downloads](https://img.shields.io/github/downloads/KUSK-TOP/kusk-php/total)](https://github.com/KUSK-TOP/kusk-php/releases)

Set of classes to deal with `KUSK`'s `API`.

## Examples

Common code:
```php
include __DIR__ . '/vendor/autoload.php';

$base_uri = 'https://api.kusk.top';
$accessToken = null;

use KUSK\API;

$api = new API($base_uri, $accessToken);
```

### Net Info

```php
echo "== Net Info ==\n";
$netInfo = $api->getNetInfo();
echo json_encode($netInfo) . "\n";
echo "==============\n\n";
```

### Block Count
```php
echo "== Block Count ==\n";
$blockCount = $api->getBlockCount();
echo "Height: {$blockCount}\n";
echo "=================\n\n";
```

### Block
```php
echo "== Block ==\n";
$block = $api->getBlock($6635);
echo "Block({$blockCount}): {$block->hash}\n";
echo "===========\n\n";
```

### Transaction
```php
echo "== Transaction ==\n";
try {
    $transaction = $api->getTransaction("007764eeb1cee5bb3650eddb4c164dd9ab8aab24a12462e954d9f2985180970d");
    echo json_encode($transaction, JSON_PRETTY_PRINT) . "\n";
} catch (Exception $e) {
    echo "Error: ". $e->getMessage() ."\n";
}
echo "===========\n\n";
```

### List Pending Transactions
```php
echo "== List Pending Transactions ==\n";
$transactions = $api->getPendingTransactions();
echo json_encode($transactions, JSON_PRETTY_PRINT)."\n";
echo "===========\n\n";
```

### Get Pending Transaction
```php
echo "== Get Pending Transaction ==\n";
$transaction = $api->getPendingTransaction("007764eeb1cee5bb3650eddb4c164dd9ab8aab24a12462e954d9f2985180970d");
echo json_encode($transaction, JSON_PRETTY_PRINT)."\n";
echo "===========\n\n";
```

### List Assets
```php
echo "== List Assets ==\n";
$assets = $api->getAssets();
echo json_encode($assets, JSON_PRETTY_PRINT)."\n";
echo "===========\n\n";
```

### Get Asset
```php
echo "== Get Asset ==\n";
$asset = $api->getAsset('ffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffffff');
echo json_encode($asset, JSON_PRETTY_PRINT)."\n";
echo "===========\n\n";
```