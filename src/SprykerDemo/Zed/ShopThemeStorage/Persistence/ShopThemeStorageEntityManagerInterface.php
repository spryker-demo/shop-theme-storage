<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;
use Generated\Shared\Transfer\ShopThemeTransfer;
use Generated\Shared\Transfer\StoreTransfer;

interface ShopThemeStorageEntityManagerInterface
{
    /**
     * @param \Generated\Shared\Transfer\ShopThemeTransfer $shopThemeTransfer
     * @param \Generated\Shared\Transfer\StoreTransfer $storeTransfer
     *
     * @return void
     */
    public function saveShopThemeStorage(ShopThemeTransfer $shopThemeTransfer, StoreTransfer $storeTransfer): void;

    /**
     * @param \Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer
     *
     * @return void
     */
    public function deleteShopThemeStorage(ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer): void;
}
