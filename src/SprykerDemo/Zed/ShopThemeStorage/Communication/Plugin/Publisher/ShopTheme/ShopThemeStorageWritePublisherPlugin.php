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
class ShopThemeStorageWritePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * {@inheritDoc}
     * - Gets Shop theme ids from event transfers.
     * - Publishes shop theme data to storage table.
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
        $this->getFacade()->writeByShopThemeEvents($eventEntityTransfers);
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
            ShopThemeStorageConfig::ENTITY_SPY_SHOP_THEME_CREATE,
            ShopThemeStorageConfig::ENTITY_SPY_SHOP_THEME_UPDATE,
        ];
    }
}
