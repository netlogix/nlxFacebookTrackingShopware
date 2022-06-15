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
use nlxFacebookTrackingShopware\Services\TrackingConsentServiceInterface;
use Shopware\Bundle\CookieBundle\Services\CookieHandler;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;

class FrontendSubscriber implements SubscriberInterface
{
    /** @var Config */
    private $config;

    /** @var ContextServiceInterface */
    private $contextService;

    /** @var TrackingConsentServiceInterface */
    private $trackingConsentService;

    public function __construct(
        Config $config,
        ContextServiceInterface $contextService,
        TrackingConsentServiceInterface $trackingConsentService
    ) {
        $this->config = $config;
        $this->contextService = $contextService;
        $this->trackingConsentService = $trackingConsentService;
    }

    /**
     * {@inheritdoc}
     */
    public static function getSubscribedEvents()
    {
        return [
            'Enlight_Controller_Action_PostDispatchSecure_Frontend' => 'onFrontendDispatched',
        ];
    }

    public function onFrontendDispatched(\Enlight_Controller_ActionEventArgs $args): void
    {
        $view = $args->getSubject()->View();

        $enableTracking = true;
        if ($this->config->useCookieConsentManager()) {
            $cookiePreferences = $args->getRequest()->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME);
            $enableTracking = $this->trackingConsentService->enableTracking($cookiePreferences);
        }

        $view->assign([
            'nlxFacebookTrackingActive' => $enableTracking,
            'nlxFacebookTrackingPixelId' => $this->config->getPixelId(),
            'nlxFacebookTrackingCurrency' => $this->contextService->getShopContext()->getCurrency()->getName(),
        ]);
    }
}
