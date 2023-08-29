<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Client\ShopThemeStorage;

use Spryker\Client\Kernel\AbstractFactory;
use Spryker\Client\Storage\StorageClientInterface;
use Spryker\Client\Store\StoreClientInterface;
use SprykerDemo\Client\ShopThemeStorage\Reader\ShopThemeStorageReader;
use SprykerDemo\Client\ShopThemeStorage\Reader\ShopThemeStorageReaderInterface;

class ShopThemeStorageFactory extends AbstractFactory
{
    /**
     * @return \SprykerDemo\Client\ShopThemeStorage\Reader\ShopThemeStorageReaderInterface
     */
    public function createShopThemeStorageReader(): ShopThemeStorageReaderInterface
    {
        return new ShopThemeStorageReader(
            $this->getStorageClient(),
            $this->getStoreClient(),
        );
    }

    /**
     * @return \Spryker\Client\Storage\StorageClientInterface
     */
    public function getStorageClient(): StorageClientInterface
    {
        return $this->getProvidedDependency(ShopThemeStorageDependencyProvider::CLIENT_STORAGE);
    }

    /**
     * @return \Spryker\Client\Store\StoreClientInterface
     */
    public function getStoreClient(): StoreClientInterface
    {
        return $this->getProvidedDependency(ShopThemeStorageDependencyProvider::CLIENT_STORE);
    }
}
