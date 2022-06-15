<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxFacebookTrackingShopware\Subscriber;

use Enlight\Event\SubscriberInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Product\Price;

class ListPriceConversionSubscriber implements SubscriberInterface
{
    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Legacy_Struct_Converter_Convert_Product_Price' => 'onPriceStructConverted',
        ];
    }

    public function onPriceStructConverted(\Enlight_Event_EventArgs $args): void
    {
        $convertedPrice = $args->getReturn();
        /** @var Price $price */
        $price = $args->get('price');

        $convertedPrice['priceNumeric'] = $price->getCalculatedPrice();

        $args->setReturn($convertedPrice);
    }
}
