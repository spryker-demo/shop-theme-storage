<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Orm\Zed\ShopThemeStorage\Persistence\SpyShopThemeStorageQuery;
use Spryker\Zed\Kernel\Persistence\AbstractPersistenceFactory;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 */
class ShopThemeStoragePersistenceFactory extends AbstractPersistenceFactory
{
    /**
     * @return \Orm\Zed\ShopThemeStorage\Persistence\SpyShopThemeStorageQuery
     */
    public function createShopThemeStorageQuery(): SpyShopThemeStorageQuery
    {
        return SpyShopThemeStorageQuery::create();
    }
}
