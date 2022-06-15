<?php
declare(strict_types=1);

/*
 * Created by netlogix GmbH & Co. KG
 *
 * @copyright netlogix GmbH & Co. KG
 */

namespace nlxFacebookTrackingShopware\Services;

use Shopware\Components\Plugin\CachedConfigReader;

class Config implements ConfigInterface
{
    const PLUGIN_NAME = 'nlxFacebookTrackingShopware';

    /** @var mixed[] */
    protected $config;

    public function __construct(CachedConfigReader $configReader)
    {
        $this->config = $configReader->getByPluginName(self::PLUGIN_NAME);
    }

    /**
     * {@inheritdoc}
     */
    public function getConfig(): array
    {
        return $this->config;
    }

    /**
     * {@inheritdoc}
     */
    public function get(string $key)
    {
        return $this->config[$key];
    }

    /**
     * {@inheritdoc}
     */
    public function set(string $key, string $value): void
    {
        $this->config[$key] = $value;
    }

    public function getPixelId(): string
    {
        return $this->get('nlxFacebookTrackingPixelId');
    }

    public function useCookieConsentManager(): bool
    {
        return $this->get('nlxFacebookTrackingPixelUseCookieConsentManager');
    }
}
