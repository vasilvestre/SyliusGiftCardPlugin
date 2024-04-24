<?php

declare(strict_types=1);

namespace Setono\SyliusGiftCardPlugin\Tests\Behat\Context\Ui;

use Behat\Behat\Context\Context;
use Setono\SyliusGiftCardPlugin\Doctrine\ORM\GiftCardRepository;
use Setono\SyliusGiftCardPlugin\Model\ProductInterface;
use Sylius\Behat\Service\Checker\EmailChecker;
use Sylius\Component\Core\Model\OrderInterface;
use Sylius\Component\Core\Repository\OrderRepositoryInterface;
use Webmozart\Assert\Assert;

final class EmailContext implements Context
{
    public function __construct(
        private readonly EmailChecker $emailChecker,
        private readonly OrderRepositoryInterface $orderRepository,
        private readonly GiftCardRepository $giftCardRepository,
    ) {
    }

    /**
     * @Then I should receive an email with gift card code
     */
    public function iShouldReceiveAnEmailWithGiftCard(): void
    {
        /** @var OrderInterface $order */
        $order = $this->orderRepository->findAll()[0];

        foreach ($order->getItems() as $orderItem) {
            /** @var ProductInterface $product */
            $product = $orderItem->getProduct();

            if (!$product->isGiftCard()) {
                continue;
            }

            foreach ($orderItem->getUnits() as $orderItemUnit) {
                $giftCard = $this->giftCardRepository->findOneByOrderItemUnit($orderItemUnit);

                Assert::true($giftCard->isEnabled(), 'Gift card is not enabled');

                $this->assertEmailContainsMessageTo($giftCard->getCode(), $order->getCustomer()->getEmail());
            }
        }
    }

    private function assertEmailContainsMessageTo(string $message, string $recipient): void
    {
        Assert::true($this->emailChecker->hasMessageTo($message, $recipient), 'The email is wrong');
    }
}
