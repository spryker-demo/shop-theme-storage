<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business;

use Spryker\Zed\Kernel\Business\AbstractBusinessFactory;
use Spryker\Zed\Store\Business\StoreFacadeInterface;
use SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface;
use SprykerDemo\Zed\ShopThemeStorage\Business\Writer\ShopThemeStorageWriter;
use SprykerDemo\Zed\ShopThemeStorage\Business\Writer\ShopThemeStorageWriterInterface;
use SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageDependencyProvider;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 * @method \SprykerDemo\Zed\ShopThemeStorage\Persistence\ShopThemeStorageEntityManagerInterface getEntityManager()
 */
class ShopThemeStorageBusinessFactory extends AbstractBusinessFactory
{
    /**
     * @return \SprykerDemo\Zed\ShopThemeStorage\Business\Writer\ShopThemeStorageWriterInterface
     */
    public function createShopThemeStorageWriter(): ShopThemeStorageWriterInterface
    {
        return new ShopThemeStorageWriter(
            $this->getShopThemeFacade(),
            $this->getStoreFacade(),
            $this->getEntityManager(),
        );
    }

    /**
     * @return \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface
     */
    public function getShopThemeFacade(): ShopThemeFacadeInterface
    {
        return $this->getProvidedDependency(ShopThemeStorageDependencyProvider::FACADE_SHOP_THEME);
    }

    /**
     * @return \Spryker\Zed\Store\Business\StoreFacadeInterface
     */
    public function getStoreFacade(): StoreFacadeInterface
    {
        return $this->getProvidedDependency(ShopThemeStorageDependencyProvider::FACADE_STORE);
    }
}
