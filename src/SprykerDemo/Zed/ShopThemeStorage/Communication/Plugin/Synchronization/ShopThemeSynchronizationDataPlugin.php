<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Communication\Plugin\Synchronization;

use Generated\Shared\Transfer\FilterTransfer;
use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
use Generated\Shared\Transfer\SynchronizationDataTransfer;
use Propel\Runtime\Collection\ObjectCollection;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\SynchronizationExtension\Dependency\Plugin\SynchronizationDataBulkRepositoryPluginInterface;
use SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageRepositoryInterface getRepository()
 * @method \SprykerDemo\Zed\ShopThemeStorage\Business\ShopThemeStorageFacadeInterface getFacade()
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 */
class ShopThemeSynchronizationDataPlugin extends AbstractPlugin implements SynchronizationDataBulkRepositoryPluginInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return ShopThemeStorageConfig::SHOP_THEME_RESOURCE_NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return bool
     */
    public function hasStore(): bool
    {
        return true;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $offset
     * @param int $limit
     * @param array<int> $ids
     *
     * @return array<\Generated\Shared\Transfer\SynchronizationDataTransfer>
     */
    public function getData(int $offset, int $limit, array $ids = []): array
    {
        $shopThemeEntityCollectionTransfer = $this->getRepository()
            ->getShopThemeEntityCollectionTransfer(
                (new ShopThemeStorageCriteriaTransfer())
                    ->setFilter($this->createFilterTransfer($offset, $limit))
                    ->setShopThemeIds($ids),
            );

        return $this->mapShopThemeIdsToSynchronizationDataTransfers($shopThemeEntityCollectionTransfer);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return array<string, mixed>
     */
    public function getParams(): array
    {
        return [];
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getQueueName(): string
    {
        return ShopThemeStorageConfig::SHOP_THEME_SYNC_STORAGE_QUEUE;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function getSynchronizationQueuePoolName(): ?string
    {
        return null;
    }

    /**
     * @param int $offset
     * @param int $limit
     *
     * @return \Generated\Shared\Transfer\FilterTransfer
     */
    protected function createFilterTransfer(int $offset, int $limit): FilterTransfer
    {
        return (new FilterTransfer())
            ->setOffset($offset)
            ->setLimit($limit);
    }

    /**
     * @param \Propel\Runtime\Collection\ObjectCollection<\Orm\Zed\ShopThemeStorage\Persistence\SpyShopThemeStorage> $shopThemeStorageEntityCollection
     *
     * @return array<\Generated\Shared\Transfer\SynchronizationDataTransfer>
     */
    protected function mapShopThemeIdsToSynchronizationDataTransfers(ObjectCollection $shopThemeStorageEntityCollection): array
    {
        $synchronizationDataTransfers = [];

        foreach ($shopThemeStorageEntityCollection as $shopThemeEntity) {
            $synchronizationDataTransfers[] = (new SynchronizationDataTransfer())
                ->fromArray($shopThemeEntity->toArray(), true);
        }

        return $synchronizationDataTransfers;
    }
}
