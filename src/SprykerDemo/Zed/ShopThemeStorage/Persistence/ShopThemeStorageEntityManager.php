<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Generated\Shared\Transfer\ShopThemeTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Spryker\Zed\Kernel\Persistence\AbstractEntityManager;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStoragePersistenceFactory getFactory()
 */
class ShopThemeStorageEntityManager extends AbstractEntityManager implements ShopThemeStorageEntityManagerInterface
{
    /**
     * @uses \SprykerDemo\Zed\ShopTheme\ShopThemeConfig::FRONTEND_CONFIG_REDIS_KEY_SUFFIX
     *
     * @var string
     */
    protected const FK_SHOP_THEME = 'FRONTEND_CONFIG';

    /**
     * @param \Generated\Shared\Transfer\ShopThemeTransfer $shopThemeTransfer
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    public function saveShopThemeStorage(ShopThemeTransfer $shopThemeTransfer, StoreTransfer $storeTransfer): void
    {
        $shopThemeStorageEntity = $this->getFactory()
            ->createShopThemeStorageQuery()
            ->filterByStore($storeTransfer->getName())
            ->findOneOrCreate();

        $shopThemeStorageEntity->setData($shopThemeTransfer->getData());

        $shopThemeStorageEntity->save();
    }
}
