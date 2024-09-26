<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Communication\Plugin\Publisher\ShopTheme;

use Generated\Shared\Transfer\ShopThemeCriteriaTransfer;
use Spryker\Zed\Kernel\Communication\AbstractPlugin;
use Spryker\Zed\PublisherExtension\Dependency\Plugin\PublisherTriggerPluginInterface;
use SprykerDemo\Shared\ShopThemeStorage\ShopThemeStorageConfig;

/**
 * @method \SprykerDemo\Zed\ShopThemeStorage\Business\ShopThemeStorageFacadeInterface getFacade()
 * @method \SprykerDemo\Zed\ShopThemeStorage\Communication\ShopThemeStorageCommunicationFactory getFactory()
 * @method \SprykerDemo\Zed\ShopThemeStorage\ShopThemeStorageConfig getConfig()
 */
class ShopThemeStoragePublisherTriggerPlugin extends AbstractPlugin implements PublisherTriggerPluginInterface
{
    /**
     * @uses \Orm\Zed\ShopTheme\Persistence\Map\SpyShopThemeTableMap::COL_ID_SHOP_THEME
     *
     * @var string
     */
    public const COL_ID_SHOP_THEME = 'spy_shop_theme.id_shop_theme';

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @param int $offset
     * @param int $limit
     *
     * @return array<\Generated\Shared\Transfer\ShopThemeTransfer>
     */
    public function getData(int $offset, int $limit): array
    {
        return $this->getFactory()
            ->getShopThemeFacade()
            ->getShopThemes(
                (new ShopThemeCriteriaTransfer())
                    ->setLimit($limit)
                    ->setOffset($offset),
            );
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getResourceName(): string
    {
        return ShopThemeStorageConfig::SHOP_THEME_RESOURCE_NAME;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string
     */
    public function getEventName(): string
    {
        return ShopThemeStorageConfig::ENTITY_SPY_SHOP_THEME_PUBLISH;
    }

    /**
     * {@inheritDoc}
     *
     * @api
     *
     * @return string|null
     */
    public function getIdColumnName(): ?string
    {
        return static::COL_ID_SHOP_THEME;
    }
}
