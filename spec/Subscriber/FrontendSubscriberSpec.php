<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace spec\nlxFacebookTrackingShopware\Subscriber;

use Enlight\Event\SubscriberInterface;
use nlxFacebookTrackingShopware\Services\Config;
use nlxFacebookTrackingShopware\Services\TrackingConsentServiceInterface;
use nlxFacebookTrackingShopware\Subscriber\FrontendSubscriber;
use PhpSpec\ObjectBehavior;
use Shopware\Bundle\CookieBundle\Services\CookieHandler;
use Shopware\Bundle\StoreFrontBundle\Service\ContextServiceInterface;
use Shopware\Bundle\StoreFrontBundle\Struct\Currency;
use Shopware\Bundle\StoreFrontBundle\Struct\ShopContextInterface;

class FrontendSubscriberSpec extends ObjectBehavior
{
    public function let(
        Config $config,
        ContextServiceInterface $contextService,
        ShopContextInterface $shopContext,
        Currency $currency,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_View_Default $view,
        \Enlight_Controller_Action $controller,
        \Enlight_Controller_Request_Request $request,
        TrackingConsentServiceInterface $trackingConsentService
    ): void {
        $config->getPixelId()
            ->willReturn('1337');

        $contextService->getShopContext()
            ->willReturn($shopContext);

        $shopContext->getCurrency()
            ->willReturn($currency);

        $currency->getName()
            ->wilLReturn('Euro');

        $args->getSubject()
            ->willReturn($controller);

        $args->getRequest()
            ->willReturn($request);

        $request->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME)
            ->willReturn('');

        $controller->View()
            ->willReturn($view);

        $this->beConstructedWith($config, $contextService, $trackingConsentService);
    }

    public function it_should_be_initializable(): void
    {
        $this->shouldHaveType(FrontendSubscriber::class);
    }

    public function it_implements_the_subscriber_interface(): void
    {
        $this->shouldImplement(SubscriberInterface::class);
    }

    public function it_should_assign_the_required_template_vars(
        Config $config,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_View_Default $view,
        \Enlight_Controller_Request_Request $request
    ): void {
        $config->useCookieConsentManager()
            ->willReturn(false);

        $view->assign([
            'nlxFacebookTrackingActive' => true,
            'nlxFacebookTrackingPixelId' => '1337',
            'nlxFacebookTrackingCurrency' => 'Euro',
        ])->shouldBeCalled();

        $this->onFrontendDispatched($args);
    }

    public function it_should_not_enable_tracking_if_the_traking_consent_service_doesnt_allow_it(
        Config $config,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_View_Default $view,
        \Enlight_Controller_Request_Request $request,
        TrackingConsentServiceInterface $trackingConsentService
    ): void {
        $config->useCookieConsentManager()
            ->willReturn(true);

        $request->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME)
            ->willReturn('');

        $trackingConsentService->enableTracking('')
            ->willReturn(false);

        $view->assign([
            'nlxFacebookTrackingActive' => false,
            'nlxFacebookTrackingPixelId' => '1337',
            'nlxFacebookTrackingCurrency' => 'Euro',
        ])->shouldBeCalled();

        $this->onFrontendDispatched($args);
    }

    public function it_should_not_call_the_tracking_consent_service_if_the_cookie_consent_manager_isnt_used(
        Config $config,
        \Enlight_Controller_ActionEventArgs $args,
        \Enlight_View_Default $view,
        \Enlight_Controller_Request_Request $request,
        TrackingConsentServiceInterface $trackingConsentService
    ): void {
        $config->useCookieConsentManager()
            ->willReturn(false);

        $request->getCookie(CookieHandler::PREFERENCES_COOKIE_NAME)
            ->shouldNotBeCalled();

        $trackingConsentService->enableTracking('')
            ->shouldNotBeCalled();

        $view->assign([
            'nlxFacebookTrackingActive' => true,
            'nlxFacebookTrackingPixelId' => '1337',
            'nlxFacebookTrackingCurrency' => 'Euro',
        ])->shouldBeCalled();

        $this->onFrontendDispatched($args);
    }
}
