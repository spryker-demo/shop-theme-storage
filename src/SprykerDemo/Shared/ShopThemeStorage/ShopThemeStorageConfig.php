<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Shared\ShopThemeStorage;

use Spryker\Shared\Kernel\AbstractBundleConfig;

class ShopThemeStorageConfig extends AbstractBundleConfig
{
    /**
     * Specification:
     * - Represents spy_shop_theme entity creation.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_CREATE = 'Entity.spy_shop_theme.create';

    /**
     * Specification:
     * - Represents spy_shop_theme entity changes.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_UPDATE = 'Entity.spy_shop_theme.update';

    /**
     * Specification:
     * - Represents spy_shop_theme entity deletion.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_DELETE = 'Entity.spy_shop_theme.delete';

    /**
     * Specification:
     * - Represents spy_shop_theme_store entity creation.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_STORE_CREATE = 'Entity.spy_shop_theme_store.create';

    /**
     * Specification:
     * - Represents spy_shop_theme_store entity changes.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_STORE_UPDATE = 'Entity.spy_shop_theme_store.update';

    /**
     * Specification:
     * - Represents spy_shop_theme_store entity deletion.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_STORE_DELETE = 'Entity.spy_shop_theme_store.delete';

    /**
     * Specification:
     * - Represents ShopTheme publish event.
     *
     * @api
     *
     * @var string
     */
    public const ENTITY_SPY_SHOP_THEME_PUBLISH = 'ShopTheme.shop_theme.publish';

    /**
     * Specification:
     * - Resource name, this will use for key generating.
     *
     * @api
     *
     * @var string
     */
    public const SHOP_THEME_RESOURCE_NAME = 'shop_theme';
}
