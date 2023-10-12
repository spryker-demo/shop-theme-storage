<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractFacade;

/**
 * @api
 *
 * @method \SprykerDemo\Zed\ShopThemeStorage\Business\ShopThemeStorageBusinessFactory getFactory()
 */
class ShopThemeStorageFacade extends AbstractFacade implements ShopThemeStorageFacadeInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createShopThemeStorageWriter()
            ->writeByShopThemeEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeStoreEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createShopThemeStorageWriter()
            ->writeByShopThemeStoreEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeStoreEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createShopThemeStorageDeleter()
            ->deleteByShopThemeStoreEvents($eventEntityTransfers);
    }

    /**
     * {@inheritDoc}
     *
     * @api
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeEvents(array $eventEntityTransfers): void
    {
        $this->getFactory()
            ->createShopThemeStorageDeleter()
            ->deleteByShopThemeEvents($eventEntityTransfers);
    }
}
