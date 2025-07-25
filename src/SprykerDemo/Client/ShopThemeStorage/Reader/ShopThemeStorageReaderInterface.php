<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Client\ShopThemeStorage\Reader;

use Generated\Shared\Transfer\ShopThemeDataTransfer;

interface ShopThemeStorageReaderInterface
{
    /**
     * @return \Generated\Shared\Transfer\ShopThemeDataTransfer
     */
    public function getActiveThemeData(): ShopThemeDataTransfer;
}
