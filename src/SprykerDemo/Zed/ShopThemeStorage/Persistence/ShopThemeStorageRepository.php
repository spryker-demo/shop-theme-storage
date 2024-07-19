<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Persistence\AbstractRepository;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStoragePersistenceFactory getFactory()
 */
class ShopThemeStorageRepository extends AbstractRepository implements ShopThemeStorageRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer
     *
     * @return array<int>
     */
    public function getShopThemeIds(ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer): array
    {
        $shopThemeStorageQuery = $this->getFactory()
            ->createShopThemeStorageQuery();

        if ($shopThemeStorageCriteriaTransfer->getStoreNames()) {
            $shopThemeStorageQuery->filterByStore_In($shopThemeStorageCriteriaTransfer->getStoreNames());
        }

        if ($shopThemeStorageCriteriaTransfer->getShopThemeIds()) {
            $shopThemeStorageQuery->filterByFkShopTheme_In($shopThemeStorageCriteriaTransfer->getShopThemeIds());
        }

        /** @var \Propel\Runtime\Collection\ObjectCollection $shopThemeStorageEntities */
        $shopThemeStorageEntities = $shopThemeStorageQuery->find();

        return $shopThemeStorageEntities->getColumnValues('fkShopTheme');
    }

    /**
     * @param \Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer
     *
     * @return \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShopThemeStorage\Persistence\SpyShopThemeStorage>
     */
    public function getShopThemeEntityCollectionTransfer(ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer): ObjectCollection
    {
        $shopThemeStorageQuery = $this->getFactory()
            ->createShopThemeStorageQuery();

        if ($shopThemeStorageCriteriaTransfer->getShopThemeIds()) {
            $shopThemeStorageQuery->filterByFkShopTheme_In($shopThemeStorageCriteriaTransfer->getShopThemeIds());
        }

        if ($shopThemeStorageCriteriaTransfer->getFilter()->getLimit()) {
            $shopThemeStorageQuery->setLimit($shopThemeStorageCriteriaTransfer->getFilter()->getLimit());
        }

        if ($shopThemeStorageCriteriaTransfer->getFilter()->getOffset()) {
            $shopThemeStorageQuery->setOffset($shopThemeStorageCriteriaTransfer->getFilter()->getOffset());
        }

        /** @var \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShopThemeStorage\Persistence\SpyShopThemeStorage> $shopThemeStorageEntities */
        $shopThemeStorageEntities = $shopThemeStorageQuery->find();

        return $shopThemeStorageEntities;
    }
}
