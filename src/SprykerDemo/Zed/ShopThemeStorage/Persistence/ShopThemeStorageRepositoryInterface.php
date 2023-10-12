<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Persistence;

use Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer;

interface ShopThemeStorageRepositoryInterface
{
    /**
     * @param \Generated\Shared\Transfer\ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer
     *
     * @return array<int>
     */
    public function getShopThemeIds(ShopThemeStorageCriteriaTransfer $shopThemeStorageCriteriaTransfer): array;
}
