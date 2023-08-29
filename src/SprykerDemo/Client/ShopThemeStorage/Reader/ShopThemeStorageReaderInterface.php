<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Client\ShopThemeStorage\Reader;

use Generated\Shared\Transfer\ShopThemeTransfer;

interface ShopThemeStorageReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\ShopThemeTransfer
     */
    public function getActiveTheme(): ShopThemeTransfer;
}
