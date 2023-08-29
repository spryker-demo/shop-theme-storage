<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Client\ShopThemeStorage;

use Generated\Shared\Transfer\ShopThemeTransfer;
use Spryker\Client\Kernel\AbstractClient;

/**
 * @method \SprykerDemo\Client\ShopThemeStorage\ShopThemeStorageFactory getFactory()
 */
class ShopThemeStorageClient extends AbstractClient implements ShopThemeStorageClientInterface
{
    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return \Generated\Shared\Transfer\ShopThemeTransfer
     */
    public function getActiveTheme(): ShopThemeTransfer
    {
        return $this->getFactory()
            ->createShopThemeStorageReader()
            ->getActiveTheme();
    }
}
