<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business\Deleter;

use Generated\Shared\Transfer\ShopThemeCriteriaTransfer;
use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
use Generated\Shared\Transfer\StoreCollectionTransfer;
use Generated\Shared\Transfer\StoreConditionsTransfer;
use Generated\Shared\Transfer\StoreCriteriaTransfer;
use Generated\Shared\Transfer\StoreTransfer;
use Orm\Zed\ShopTheme\Persistence\Map\SpyShopThemeStoreTableMap;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface;
use SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface;
use SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface;

class ShopThemeStorageDeleter implements ShopThemeStorageDeleterInterface
{
    use TransactionTrait;

    /**
     * @var string
     */
    protected const STATUS_ACTIVE = 'active';

    /**
     * @var \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected EventBehaviorFacadeInterface $eventBehaviorFacade;

    /**
     * @var \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface
     */
    protected ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected StoreFacadeInterface $storeFacade;

    /**
     * @var \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface
     */
    protected ShopThemeFacadeInterface $shopThemeFacade;

    /**
     * @var \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface
     */
    protected ShopThemeStorageRepositoryInterface $shopThemeStorageRepository;

    /**
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface $shopThemeStorageRepository
     * @param \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface $shopThemeFacade
     */
    public function __construct(
        EventBehaviorFacadeInterface $eventBehaviorFacade,
        ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager,
        StoreFacadeInterface $storeFacade,
        ShopThemeStorageRepositoryInterface $shopThemeStorageRepository,
        ShopThemeFacadeInterface $shopThemeFacade
    ) {
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->shopThemeStorageEntityManager = $shopThemeStorageEntityManager;
        $this->storeFacade = $storeFacade;
        $this->shopThemeStorageRepository = $shopThemeStorageRepository;
        $this->shopThemeFacade = $shopThemeFacade;
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeEvents(array $eventEntityTransfers): void
    {
        $shopThemeIds = $this->eventBehaviorFacade->getEventTransferIds($eventEntityTransfers);

        if (!$shopThemeIds) {
            return;
        }

        $this->getTransactionHandler()->handleTransaction(function () use ($shopThemeIds) {
            $this->shopThemeStorageEntityManager->deleteShopThemeStorage(
                (new ShopThemeStorageCriteriaTransfer())->setShopThemeIds($shopThemeIds),
            );
        });
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeStoreEvents(array $eventEntityTransfers): void
    {
        $shopThemeStoreEventsForeignKeysGroupedByStoreId = $this->eventBehaviorFacade->getGroupedEventTransferForeignKeysByForeignKey($eventEntityTransfers, SpyShopThemeStoreTableMap::COL_FK_STORE);

        if (!$shopThemeStoreEventsForeignKeysGroupedByStoreId) {
            return;
        }

        $this->getTransactionHandler()->handleTransaction(function () use ($shopThemeStoreEventsForeignKeysGroupedByStoreId) {
            $this->executeDeleteByShopThemeStoreEvents($shopThemeStoreEventsForeignKeysGroupedByStoreId);
        });
    }

    /**
     * @param array<int, array<mixed>> $shopThemeStoreEventsForeignKeysGroupedByStoreId
     *
     * @return void
     */
    protected function executeDeleteByShopThemeStoreEvents(array $shopThemeStoreEventsForeignKeysGroupedByStoreId): void
    {
        $storeIds = array_keys($shopThemeStoreEventsForeignKeysGroupedByStoreId);
        $storeCollectionTransfer = $this->storeFacade->getStoreCollection((new StoreCriteriaTransfer())->setStoreConditions((new StoreConditionsTransfer())->setStoreIds($storeIds)));
        $storeNames = $this->extractStoreNamesFromStoreCollection($storeCollectionTransfer);
        $existingShopThemeIds = $this->getExistingShopThemeIds($storeNames, $storeIds);

        if (!$existingShopThemeIds) {
            return;
        }

        foreach ($storeCollectionTransfer->getStores() as $store) {
            if (!isset($shopThemeStoreEventsForeignKeysGroupedByStoreId[$store->getIdStore()])) {
                continue;
            }

            $this->deleteShopThemeStorageByStore($shopThemeStoreEventsForeignKeysGroupedByStoreId[$store->getIdStore()], $store, $existingShopThemeIds);
        }
    }

    /**
     * @param \Generated\Shared\Transfer\StoreCollectionTransfer $storeCollectionTransfer
     *
     * @return array<string>
     */
    protected function extractStoreNamesFromStoreCollection(StoreCollectionTransfer $storeCollectionTransfer): array
    {
        $storeNames = [];
        foreach ($storeCollectionTransfer->getStores() as $store) {
            $storeNames[] = $store->getName();
        }

        return $storeNames;
    }

    /**
     * @param array<string> $storeNames
     * @param array<int> $storeIds
     *
     * @return array<int>
     */
    protected function getExistingShopThemeIds(array $storeNames, array $storeIds): array
    {
         return array_diff(
             $this->shopThemeStorageRepository->getShopThemeIds((new ShopThemeStorageCriteriaTransfer())->setStoreNames($storeNames)),
             $this->shopThemeFacade->getShopThemeIds((new ShopThemeCriteriaTransfer())->setStoreIds($storeIds)),
         );
    }

    /**
     * @param array<int, mixed> $shopThemeStoreEventForeignKeys
     * @param \Generated\Shared\Transfer\StoreTransfer $store
     * @param array<int> $existingShopThemeIds
     *
     * @return void
     */
    protected function deleteShopThemeStorageByStore(array $shopThemeStoreEventForeignKeys, StoreTransfer $store, array $existingShopThemeIds): void
    {
        foreach ($shopThemeStoreEventForeignKeys as $eventForeignKeys) {
            $shopThemeId = $eventForeignKeys[SpyShopThemeStoreTableMap::COL_FK_SHOP_THEME] ?? null;

            if ($shopThemeId === null || !in_array($shopThemeId, $existingShopThemeIds)) {
                continue;
            }

            $this->shopThemeStorageEntityManager->deleteShopThemeStorage(
                (new ShopThemeStorageCriteriaTransfer())
                    ->setShopThemeIds([$shopThemeId])
                    ->setStoreNames([$store->getName()]),
            );
        }
    }
}
