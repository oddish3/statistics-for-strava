<?php

declare(strict_types=1);

namespace App\Domain\Integration\AI\Tool;

use App\Domain\Strava\Activity\ActivitiesEnricher;
use App\Domain\Strava\Activity\ActivityId;
use NeuronAI\Tools\PropertyType;
use NeuronAI\Tools\Tool;
use NeuronAI\Tools\ToolProperty;

final class GetActivity extends Tool
{
    public function __construct(
        private readonly ActivitiesEnricher $activitiesEnricher,
    ) {
        parent::__construct(
            'get_activity_by_id',
            'Retrieves an activity from the database by a given id',
        );
    }

    /**
     * @return \NeuronAI\Tools\ToolPropertyInterface[]
     *
     * @codeCoverageIgnore
     */
    protected function properties(): array
    {
        return [
            new ToolProperty(
                name: 'activityId',
                type: PropertyType::STRING,
                description: 'The id of the activity.',
                required: true
            ),
        ];
    }

    /**
     * @return array<string, mixed>
     */
    public function __invoke(string $activityId): array
    {
        $activityId = ActivityId::fromUnprefixed($activityId);

        return $this->activitiesEnricher->getEnrichedActivity($activityId)->exportForAITooling();
    }
}
