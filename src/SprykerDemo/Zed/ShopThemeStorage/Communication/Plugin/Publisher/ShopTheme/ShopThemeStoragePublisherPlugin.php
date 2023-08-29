<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Communication\Plugin\Publisher\ShopTheme;

use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherPluginInterface;
use SprykerDemo\Zed\ShopTheme\Dependency\ShopThemeEvents;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Business\ShopThemeStorageFacadeInterface getFacade()
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 */
class ShopThemeStoragePublisherPlugin extends AbstractPlugin implements PublisherPluginInterface
{
    /**
     * {@inheritDoc}
     * - Gets MerchantIds from event transfers.
     * - Publish merchant data to storage table.
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
        $this->getFacade()->publish();
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
            ShopThemeEvents::SHOP_THEME_PUBLISH,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_CREATE,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_UPDATE,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_DELETE,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_STORE_CREATE,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_STORE_UPDATE,
            ShopThemeEvents::ENTITY_SPY_SHOP_THEME_STORE_DELETE,
        ];
    }
}
