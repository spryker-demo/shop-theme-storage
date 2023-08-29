<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business\Writer;

use Spryker\Zed\Store\Business\StoreFacadeInterface;
use SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface;
use SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface;

class ShopThemeStorageWriter implements ShopThemeStorageWriterInterface
{
    /**
     * @var \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface
     */
    protected ShopThemeFacadeInterface $shopThemeFacade;

    /**
     * @var \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface
     */
    protected ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager;

    /**
     * @var \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    protected StoreFacadeInterface $storeFacade;

    /**
     * @param \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface $shopThemeFacade
     * @param \Spryker\Zed\Store\Business\StoreFacadeInterface $storeFacade
     * @param \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager
     */
    public function __construct(
        ShopThemeFacadeInterface $shopThemeFacade,
        StoreFacadeInterface $storeFacade,
        ShopThemeStorageEntityManagerInterface $shopThemeStorageEntityManager
    ) {
        $this->shopThemeFacade = $shopThemeFacade;
        $this->storeFacade = $storeFacade;
        $this->shopThemeStorageEntityManager = $shopThemeStorageEntityManager;
    }

    /**
     * @return void
     */
    public function publish(): void
    {
        $availableStoresTransfers = $this->storeFacade->getAllStores();
        foreach ($availableStoresTransfers as $storeTransfer) {
            $shopThemeTransfer = $this->shopThemeFacade->getActiveTheme($storeTransfer);
            $this->shopThemeStorageEntityManager->saveShopThemeStorage($shopThemeTransfer, $storeTransfer);
        }
    }
}
