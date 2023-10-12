<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business\Writer;

use Generated\Shared\Transfer\ShopThemeCriteriaTransfer;
use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
use Orm\Zed\ShopTheme\Persistence\Map\SpyShopThemeStoreTableMap;
use Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface;
use Spryker\Zed\Kernel\Persistence\EntityManager\TransactionTrait;
use SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface;
use SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface;
use SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface;

class ShopThemeStorageWriter implements ShopThemeStorageWriterInterface
{
    use TransactionTrait;

    /**
     * @var string
     */
    protected const STATUS_ACTIVE = 'active';

    /**
     * @var \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface
     */
    protected ShopThemeFacadeInterface $shopThemeFacade;

    /**
     * @var \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface
     */
    protected ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager;

    /**
     * @var \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface
     */
    protected EventBehaviorFacadeInterface $eventBehaviorFacade;

    /**
     * @var \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface
     */
    protected ShopThemeStorageRepositoryInterface $shopThemeStorageRepository;

    /**
     * @param \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface $shopThemeFacade
     * @param \Spryker\Zed\EventBehavior\Business\EventBehaviorFacadeInterface $eventBehaviorFacade
     * @param \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager
     * @param \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface $shopThemeStorageRepository
     */
    public function __construct(
        ShopThemeFacadeInterface $shopThemeFacade,
        EventBehaviorFacadeInterface $eventBehaviorFacade,
        ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager,
        ShopThemeStorageRepositoryInterface $shopThemeStorageRepository
    ) {
        $this->shopThemeFacade = $shopThemeFacade;
        $this->eventBehaviorFacade = $eventBehaviorFacade;
        $this->shopThemeStorageEntityManager = $shopThemeStorageEntityManager;
        $this->shopThemeStorageRepository = $shopThemeStorageRepository;
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeEvents(array $eventEntityTransfers): void
    {
        $shopThemeIds = $this->eventBehaviorFacade->getEventTransferIds($eventEntityTransfers);

        $this->getTransactionHandler()->handleTransaction(function () use ($shopThemeIds) {
            $this->executeWriteShopThemeStorageByShopThemeIds($shopThemeIds);
        });
    }

    /**
     * @param array<int> $shopThemeIds
     *
     * @return void
     */
    protected function executeWriteShopThemeStorageByShopThemeIds(array $shopThemeIds): void
    {
        $shopThemeCriteriaTransfer = (new ShopThemeCriteriaTransfer())
            ->setStatus(static::STATUS_ACTIVE)
            ->setWithStoreRelations(true)
            ->setShopThemeIds($shopThemeIds);

        $activeShopThemes = $this->shopThemeFacade->getShopThemes($shopThemeCriteriaTransfer);
        $this->removeExistingInactiveThemes($shopThemeIds, $activeShopThemes);

        $this->saveActiveShopThemesToStorage($activeShopThemes);
    }

    /**
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeStoreEvents(array $eventEntityTransfers): void
    {
        $shopThemeIds = $this->eventBehaviorFacade->getEventTransferForeignKeys($eventEntityTransfers, SpyShopThemeStoreTableMap::COL_FK_SHOP_THEME);

        $this->getTransactionHandler()->handleTransaction(function () use ($shopThemeIds) {
            $this->executeWriteActiveShopThemesToStorage($shopThemeIds);
        });
    }

    /**
     * @param array<int> $shopThemeIds
     *
     * @return void
     */
    protected function executeWriteActiveShopThemesToStorage(array $shopThemeIds): void
    {
        $shopThemeCriteriaTransfer = (new ShopThemeCriteriaTransfer())
            ->setStatus(static::STATUS_ACTIVE)
            ->setWithStoreRelations(true)
            ->setShopThemeIds($shopThemeIds);

        $activeShopThemes = $this->shopThemeFacade->getShopThemes($shopThemeCriteriaTransfer);

        if (!$activeShopThemes) {
            return;
        }

        $this->saveActiveShopThemesToStorage($activeShopThemes);
    }

    /**
     * @param array $shopThemeIds
     * @param array $activeShopThemes
     *
     * @return void
     */
    protected function removeExistingInactiveThemes(array $shopThemeIds, array $activeShopThemes): void
    {
        $existingShopThemeStorageShopThemeIds = $this->shopThemeStorageRepository->getShopThemeIds(
            (new ShopThemeStorageCriteriaTransfer())->setShopThemeIds($shopThemeIds),
        );

        if (!$existingShopThemeStorageShopThemeIds) {
            return;
        }

        if (!$activeShopThemes) {
            $this->shopThemeStorageEntityManager->deleteShopThemeStorage((new ShopThemeStorageCriteriaTransfer())->setShopThemeIds($existingShopThemeStorageShopThemeIds));

            return;
        }

        $activeShopThemeIds = $this->extractActiveShopThemeIds($activeShopThemes);
        $shopThemeIdsToRemove = array_diff($existingShopThemeStorageShopThemeIds, $activeShopThemeIds);

        if ($shopThemeIdsToRemove) {
            $this->shopThemeStorageEntityManager->deleteShopThemeStorage((new ShopThemeStorageCriteriaTransfer())->setShopThemeIds($shopThemeIdsToRemove));
        }
    }

    /**
     * @param array $activeShopThemes
     *
     * @return void
     */
    protected function saveActiveShopThemesToStorage(array $activeShopThemes): void
    {
        foreach ($activeShopThemes as $activeShopTheme) {
            foreach ($activeShopTheme->getStoreRelation()->getStores() as $store) {
                $this->shopThemeStorageEntityManager->saveShopThemeStorage($activeShopTheme, $store);
            }
        }
    }

    /**
     * @param array<\Generated\Shared\Transfer\ShopThemeTransfer> $activeShopThemes
     *
     * @return array
     */
    protected function extractActiveShopThemeIds(array $activeShopThemes): array
    {
        $activeShopThemeIds = [];

        foreach ($activeShopThemes as $activeShopTheme) {
            $activeShopThemeIds[] = $activeShopTheme->getIdShopTheme();
        }

        return $activeShopThemeIds;
    }
}
