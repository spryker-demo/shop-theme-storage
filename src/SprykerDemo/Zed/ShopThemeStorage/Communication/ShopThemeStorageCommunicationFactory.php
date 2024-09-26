<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Communication;

use Spryker\Zed\Kernel\Communication\AbstractCommunicationFactory;
use SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface;
use SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageDependencyProvider;

class ShopThemeStorageCommunicationFactory extends AbstractCommunicationFactory
{
 /**
  * @return \SprykerDemo\Zed\ShopTheme\Business\ShopThemeFacadeInterface
  */
    public function getShopThemeFacade(): ShopThemeFacadeInterface
    {
        return $this->getProvidedDependency(ShopThemeStorageDependencyProvider::FACADE_SHOP_THEME);
    }
}
