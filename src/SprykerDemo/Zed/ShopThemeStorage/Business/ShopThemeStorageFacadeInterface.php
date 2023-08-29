<?php

/**
 * Copyright © 2016-present Spryker Systems GmbH. All rights reserved.
 * Use of this software requires acceptance of the Evaluation License Agreement. See LICENSE file.
 */

namespace SprykerDemo\Zed\ShopThemeStorage\Business;

interface ShopThemeStorageFacadeInterface
{
    /**
     * Specification:
     * - publishes frontend configuration to the storage.
     *
     * @api
     *
     * @return void
     */
    public function publish(): void;
}
