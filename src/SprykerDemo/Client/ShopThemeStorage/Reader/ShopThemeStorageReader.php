<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Client\ShopThemeStorage\Reader;

use Generated\Shared\Transfer\ShopThemeDataTransfer;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Client\Store\StoreClientInterface;

class ShopThemeStorageReader implements ShopThemeStorageReaderInterface
{
    /**
     * @var string
     */
    protected const KEY_SHOP_THEME = 'shop_theme:';

    /**
     * @var \Spryker\Client\Storage\StorageClientInterface
     */
    protected StorageClientInterface $storageClient;

    /**
     * @var \Spryker\Client\Store\StoreClientInterface
     */
    protected StoreClientInterface $storeClient;

    /**
     * @param \Spryker\Client\Storage\StorageClientInterface $storageClient
     * @param \Spryker\Client\Store\StoreClientInterface $storeClient
     */
    public function __construct(
        StorageClientInterface $storageClient,
        StoreClientInterface $storeClient
    ) {
        $this->storageClient = $storageClient;
        $this->storeClient = $storeClient;
    }

    /**
     * @return \Generated\Shared\Transfer\ShopThemeDataTransfer
     */
    public function getActiveThemeData(): ShopThemeDataTransfer
    {
        $storeName = $this->storeClient->getCurrentStore()->getName() ?? '';
        $shopThemeDataTransfer = new ShopThemeDataTransfer();

        if (!$storeName) {
            return $shopThemeDataTransfer;
        }

        $shopThemeStorageKey = $this->findStorageKey($storeName);

        if ($shopThemeStorageKey === null) {
            return $shopThemeDataTransfer;
        }

        $shopThemeData = $this->storageClient->get($shopThemeStorageKey);

        return $shopThemeDataTransfer->fromArray($shopThemeData ?? [], true);
    }

    /**
     * @param string $storeName
     *
     * @return string|null
     */
    protected function findStorageKey(string $storeName): ?string
    {
        $shopThemeBaseKey = static::KEY_SHOP_THEME . strtolower($storeName);
        $storageScanResultTransfer = $this->storageClient->scanKeys(sprintf('%s:*', $shopThemeBaseKey), 1);
        $keys = $storageScanResultTransfer->getKeys();
        if (!$keys) {
            return null;
        }

        $shopThemeKey = array_shift($keys);
        $shopThemeBaseKeyPos = strpos($shopThemeKey, $shopThemeBaseKey);

        return substr($shopThemeKey, $shopThemeBaseKeyPos);
    }
}
