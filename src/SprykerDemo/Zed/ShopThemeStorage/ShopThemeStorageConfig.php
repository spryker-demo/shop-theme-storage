<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage;

use Spryker\Zed\Kernel\AbstractBundleConfig;

class ShopThemeStorageConfig extends AbstractBundleConfig
{
    /**
     * Defines queue name for publish.
     *
     * @var string
     */
    public const PUBLISH_SHOP_THEME_QUEUE = 'publish.shop_theme';

    /**
     * Specification:
     * - Queue name as used for processing config container configuration messages
     *
     * @api
     *
     * @var string
     */
    public const SHOP_THEME_SYNC_STORAGE_QUEUE = 'sync.storage.shop_theme';

    /**
     * Specification:
     * - Key generation resource name for shop theme messages.
     *
     * @api
     *
     * @var string
     */
    public const SHOP_THEME_RESOURCE_NAME = 'shop_theme';

    /**
     * @api
     *
     * @return string|null
     */
    public function getShopThemeEventQueueName(): ?string
    {
        return static::PUBLISH_SHOP_THEME_QUEUE;
    }
}
