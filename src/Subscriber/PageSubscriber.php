<?php

declare(strict_types=1);

namespace AleksWsdev\ChangeColorCartButton\Subscriber;

use Shopware\Core\Content\Product\Events\ProductListingResultEvent;
use Shopware\Core\System\SystemConfig\SystemConfigService;
use Shopware\Storefront\Page\Product\ProductPageLoadedEvent;
use Symfony\Component\EventDispatcher\EventSubscriberInterface;

class PageSubscriber implements EventSubscriberInterface
{
    public function __construct(
        private readonly SystemConfigService $config,
    ) {
    }

    public static function getSubscribedEvents(): array
    {
        return [
            ProductPageLoadedEvent::class => 'onProductPageLoaded',
            ProductListingResultEvent::class => 'onProductListingResult',
        ];
    }

    public function onProductPageLoaded(ProductPageLoadedEvent $event)
    {
        $page = $event->getPage();
        $btnColor = $this->config->get('ChangeColorCartButton.config.color');
        $page->assign([
            'btnColor' => $btnColor,
        ]);
    }

    public function onProductListingResult(ProductListingResultEvent $event)
    {
        $btnColor = $this->config->get('ChangeColorCartButton.config.color');
        $products = $event->getResult();

        foreach ($products as $productEntity) {
            if ($productEntity !== null) {
                $productEntity->assign([
                    'btnColor' => $btnColor,
                ]);
            }
        };
    }
}
