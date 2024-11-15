<?php
declare(strict_types = 1);

namespace KUSK;

use KUSK\API\NetInfo;
use KUSK\API\GetBlock;
use KUSK\API\Block;
use KUSK\API\GetTransaction;
use KUSK\API\PendingTransactions;
use KUSK\API\Transaction;
use KUSK\API\BlockTransaction;
use KUSK\API\Asset;
use KUSK\API\HashRate;
use KUSK\API\ValidateAddress;

class API {
    private APIClientInterface $api_client;

    function __construct(APIClientInterface $client){
        $this->api_client = $client;
    }

    public function getNetInfo(): NetInfo|null {
        try{
            $response = $this->api_client->get('net-info');
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $net_info = new NetInfo($json->data);
                return $net_info;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getBlockCount(): int|null {
        try{
            $response = $this->api_client->get('get-block-count');
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $blockCount = intval($json->data->block_count);
                return $blockCount;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }
    public function getBlock(int $blockNum, string|null $blockHash = null): Block|null {
        try{
            $getBlock = new GetBlock($blockNum, $blockHash);
            $response = $this->api_client->post('get-block', json_encode($getBlock));
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $block = new Block($json->data);
                return $block;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getTransaction(string $hash): Transaction|null {
        try{
            $getTransaction = new GetTransaction($hash);
            $response = $this->api_client->post('get-transaction', json_encode($getTransaction));
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $transaction = new Transaction($json->data);
                return $transaction;

            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getPendingTransactions(): PendingTransactions|null {
        try{
            $response = $this->api_client->post('list-unconfirmed-transactions');
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $transactions = new PendingTransactions($json->data);
                return $transactions;

            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }
    public function getPendingTransaction(string $hash): BlockTransaction|null {
        try{
            $getTransaction = new GetTransaction($hash);
            $response = $this->api_client->post('get-unconfirmed-transaction', json_encode($getTransaction));
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $transaction = new BlockTransaction($json->data);
                return $transaction;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getAssets(): array|null {
        try{
            $response = $this->api_client->post('list-assets', '{}');
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $assets = [];
                foreach ($json->data as $asset) {
                    $assets[] = new Asset($asset);
                }
                return $assets;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getAsset(string $assetID): Asset|null {
        try{
            $response = $this->api_client->post('get-asset', "{\"id\": \"{$assetID}\"}");
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $asset = new Asset($json->data);
                return $asset;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function getHashRate(int $blockNum): HashRate|null {
        try{
            $getBlock = new GetBlock($blockNum);
            $response = $this->api_client->post('get-hash-rate', json_encode($getBlock));
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $hashRate = new HashRate($json->data);
                return $hashRate;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }

    public function validateAddress(string $address): ValidateAddress|null {
        try{
            $response = $this->api_client->post('validate-address',"{\"address\":\"{$address}\"}");
            $json = json_decode((string)$response->getBody());
            if ($response->getStatusCode() == 200 && $json->status == 'success') {
                $valid = new ValidateAddress($json->data);
                return $valid;
            } else {
                if (isset($json->detail)) {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->detail})");
                } else {
                    throw new \Exception("Error({$json->code}): {$json->msg}({$json->error_detail})");
                }
            }
        } catch (\Exception $e){
            //echo $e->getMessage() . "\n";
            return null;
        }
    }
}

