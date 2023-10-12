<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business;

interface ShopThemeStorageFacadeInterface
{
    /**
     * Specification:
     * - Publishes shop theme to the storage by shop theme events.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeEvents(array $eventEntityTransfers): void;

    /**
     * Specification:
     * - Publishes shop theme to the storage by shop theme store events.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function writeByShopThemeStoreEvents(array $eventEntityTransfers): void;

    /**
     * Specification:
     * - Removes shop theme from the storage by shop theme store events.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeStoreEvents(array $eventEntityTransfers): void;

    /**
     * Specification:
     * - Removes shop theme from the storage by shop theme events.
     *
     * @api
     *
     * @param array<\Generated\Shared\Transfer\EventEntityTransfer> $eventEntityTransfers
     *
     * @return void
     */
    public function deleteByShopThemeEvents(array $eventEntityTransfers): void;
}
