<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxFacebookTrackingShopware\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxFacebookTrackingShopware\Subscriber\ListPriceConversionSubscriber;
use PhpSpec\ObjectBehavior;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Price;

class ListPriceConversionSubscriberSpec extends ObjectBehavior
{
    public function it_is_initializable(): void
    {
        $this->shouldHaveType(ListPriceConversionSubscriber::class);
    }

    public function it_implements_the_subscriber_interface(): void
    {
        $this->shouldImplement(SubscriberInterface::class);
    }

    public function it_correctly_assigns_the_priceNumeric_field(
        \Enlight_Event_EventArgs $args,
        Price $price
    ): void {
        $args->getReturn()
            ->willReturn([]);

        $args->get('price')
            ->willReturn($price);

        $price->getCalculatedPrice()
            ->willReturn(1337.37);

        $args->setReturn([
            'priceNumeric' => 1337.37,
        ])->shouldBecalled();

        $this->onPriceStructConverted($args);
    }
}
