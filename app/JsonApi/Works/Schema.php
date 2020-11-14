<?php

namespace App\JsonApi\Works;

use App\Models\Work as Model;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'works';

    /**
     * @param Model $resource
     *      the domain record being serialized.
     * @return string
     */
    public function getId($resource)
    {
        return (string)$resource->getRouteKey();
    }

    /**
     * @param Model $resource
     *      the domain record being serialized.
     * @return array
     */
    public function getAttributes($resource)
    {
        $details = Model::FIELD_DETAILS;
        $date = Model::FIELD_DATE;
        $hours = Model::FIELD_HOURS;
        $est_hours = Model::FIELD_EST_HOURS;
        return [
            $details     => $resource->$details,
            $date        => $resource->$date->toIso8601String(),
            $hours       => $resource->$hours,
            'est-hours'  => $resource->$est_hours,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        $user = Model::REL_USER;

        return [
            $user => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships[$user]),
                self::DATA         => function () use ($resource, $user) {
                    return $resource->$user;
                }
            ]
        ];
    }
}
