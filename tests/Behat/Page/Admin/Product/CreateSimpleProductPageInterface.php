<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Page\Admin\Product;

use Sylius\Behat\Page\Admin\Product\CreateSimpleProductPageInterface as BaseCreateSimpleProductPageInterface;

interface CreateSimpleProductPageInterface extends BaseCreateSimpleProductPageInterface
{
    public function specifyGiftCard(bool $val): void;
}
