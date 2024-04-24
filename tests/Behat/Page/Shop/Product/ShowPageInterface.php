<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Page\Shop\Product;

use Sylius\Behat\Page\Shop\Product\ShowPageInterface as BaseShowPageInterface;

interface ShowPageInterface extends BaseShowPageInterface
{
    public function changeAmount(string $amount): void;

    public function defineCustomMessage(string $customMessage): void;
}
