<?php

namespace App\JsonApi\Users;

use App\Models\User as Model;
use Neomerx\JsonApi\Schema\SchemaProvider;

class Schema extends SchemaProvider
{

    /**
     * @var string
     */
    protected $resourceType = 'users';

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
        $name = Model::FIELD_NAME;
        $email = Model::FIELD_EMAIL;

        return [
            $name        => $resource->$name,
            $email       => $resource->$email,
            'created-at' => $resource->created_at->toIso8601String(),
            'updated-at' => $resource->updated_at->toIso8601String(),
        ];
    }

    public function getRelationships($resource, $isPrimary, array $includeRelationships)
    {
        $works = Model::REL_WORKS;

        return [
            $works => [
                self::SHOW_SELF    => true,
                self::SHOW_RELATED => true,
                self::SHOW_DATA    => isset($includeRelationships[$works]),
                self::DATA         => function () use ($resource, $works) {
                    return $resource->$works;
                }
            ]
        ];
    }
}
