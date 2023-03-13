<?php

declare(strict_types=1);

namespace Netgen\Layouts\Ibexa\RelationListQuery\Handler\Traits;

use Ibexa\Contracts\Core\Repository\LocationService;
use Ibexa\Contracts\Core\Repository\Values\Content\Content;
use Netgen\Layouts\API\Values\Collection\Query;
use Netgen\Layouts\Ibexa\ContentProvider\ContentProviderInterface;
use Throwable;

trait SelectedContentTrait
{
    private LocationService $locationService;

    private ContentProviderInterface $contentProvider;

    /**
     * Returns the selected Content item.
     */
    private function getSelectedContent(Query $query): ?Content
    {
        if ($query->getParameter('use_current_location')->getValue() === true) {
            return $this->contentProvider->provideContent();
        }

        $locationId = $query->getParameter('location_id')->getValue();
        if ($locationId === null) {
            return null;
        }

        try {
            return $this->locationService->loadLocation((int) $locationId)->getContent();
        } catch (Throwable) {
            return null;
        }
    }

    private function setLocationService(LocationService $locationService): void
    {
        $this->locationService = $locationService;
    }

    private function setContentProvider(ContentProviderInterface $contentProvider): void
    {
        $this->contentProvider = $contentProvider;
    }
}
