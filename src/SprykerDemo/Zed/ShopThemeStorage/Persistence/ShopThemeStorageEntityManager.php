<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
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
        $shopThemeStorageEntity->setFkShopTheme($shopThemeTransfer->getIdShopTheme());
        $shopThemeStorageEntity->setData($shopThemeTransfer->getShopThemeData()->toArray(true, true));
        $shopThemeStorageEntity->save();
    }

    /**
     * @param \Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer
     *
     * @return void
     */
    public function deleteShopThemeStorage(ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer): void
    {
        if (!$shopThemeStorageCriteriaTransfer->getStoreNames() && !$shopThemeStorageCriteriaTransfer->getShopThemeIds()) {
            return;
        }

        $shopThemeStorageQuery = $this->getFactory()
            ->createShopThemeStorageQuery();

        if ($shopThemeStorageCriteriaTransfer->getStoreNames()) {
            $shopThemeStorageQuery->filterByStore_In($shopThemeStorageCriteriaTransfer->getStoreNames());
        }

        if ($shopThemeStorageCriteriaTransfer->getShopThemeIds()) {
            $shopThemeStorageQuery->filterByFkShopTheme_In($shopThemeStorageCriteriaTransfer->getShopThemeIds());
        }

        $shopThemeStorageQuery->find()->delete();
    }
}
