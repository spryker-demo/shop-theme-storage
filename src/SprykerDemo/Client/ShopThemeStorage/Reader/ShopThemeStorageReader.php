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

        $key = static::KEY_SHOP_THEME . strtolower($storeName);
        $shopThemeData = $this->storageClient->get($key);

        return $shopThemeDataTransfer->fromArray($shopThemeData ?? [], true);
    }
}
