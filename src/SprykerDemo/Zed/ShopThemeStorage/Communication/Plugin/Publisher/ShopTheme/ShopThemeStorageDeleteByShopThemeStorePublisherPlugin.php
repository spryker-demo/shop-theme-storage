<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Communication\Plugin\Publisher\ShopTheme;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;
use SprykerDemo\Shared\ShopThemeStorage\ShopThemeStorageConfig;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Business\ShopThemeStorageFacadeInterface getFacade()
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 */
class ShopThemeStorageDeleteByShopThemeStorePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * {@inheritDoc}
     * - Gets shop theme ids from event transfers.
     * - Removes shop theme data from storage table.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     * @param string $eventName
     *
     * @return void
     */
    public function handleBulk(array $eventEntityTransfers, $eventName): void
    {
        $this->getFacade()->deleteByShopThemeStoreEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return array<string>
     */
    public function getSubscribedEvents(): array
    {
        return [
            ShopThemeStorageConfig::ENTITY_SPY_SHOP_THEME_STORE_DELETE,
        ];
    }
}
