<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxFacebookTrackingShopware\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxFacebookTrackingShopware\Services\Config;
use nlxFacebookTrackingShopware\Services\TrackingConsentService;
use nlxFacebookTrackingShopware\Services\TrackingConsentServiceInterface;
use Shopware\Bundle\CookieBundle\CookieCollection;
use Shopware\Bundle\CookieBundle\Structs\CookieGroupStruct;
use Shopware\Bundle\CookieBundle\Structs\CookieStruct;

class CookieCollectionSubscriber implements SubscriberInterface
{
    /** @var Config */
    private $config;

    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'CookieCollector_Collect_Cookies' => 'addCookies',
        ];
    }

    public function addCookies(): CookieCollection
    {
        $cookies = new CookieCollection();

        if ($this->config->useCookieConsentManager()) {
            $cookies->add(new CookieStruct(
                TrackingConsentServiceInterface::COOKIE_NAME,
                '/' . TrackingConsentService::COOKIE_NAME . '/',
                'Facebook Tracking Pixel',
                CookieGroupStruct::STATISTICS
            ));
        }

        return $cookies;
    }
}
