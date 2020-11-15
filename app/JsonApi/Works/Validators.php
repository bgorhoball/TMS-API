<?php

namespace App\JsonApi\Works;

use App\Models\User;
use App\Models\Work as Model;
use CloudCreativity\LaravelJsonApi\Rules\DateTimeIso8601;
use CloudCreativity\LaravelJsonApi\Rules\HasOne;
use CloudCreativity\LaravelJsonApi\Validation\AbstractValidators;

class Validators extends AbstractValidators
{

    /**
     * The include paths a client is allowed to request.
     *
     * @var string[]|null
     *      the allowed paths, an empty array for none allowed, or null to allow all paths.
     */
    protected $allowedIncludePaths = [
        Model::REL_USER
    ];

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = [
        Model::FIELD_DETAILS,
        Model::FIELD_DATE,
        Model::FIELD_HOURS,
        Model::FIELD_EST_HOURS,
    ];

    /**
     * The filters a client is allowed send.
     *
     * @var string[]|null
     *      the allowed filters, an empty array for none allowed, or null to allow all.
     */
    protected $allowedFilteringParameters = [
        Model::FIELD_DETAILS,
        Model::FIELD_DATE,
        Model::FIELD_HOURS,
        Model::FIELD_EST_HOURS,
    ];

    /**
     * Get resource validation rules.
     *
     * @param mixed|null $record
     *      the record being updated, or null if creating a resource.
     * @param array $data
     *      the data being validated
     * @return array
     */
    protected function rules($record, array $data): array
    {
        $id_user = User::FIELD_ID;
        $is_admin = request()->user()->roles->contains('name', 'admin');
        $validator = [
            Model::FIELD_DETAILS    => 'required|string',
            Model::FIELD_DATE       => ['required', new DateTimeIso8601()],
            Model::FIELD_HOURS      => 'nullable|integer',
            'est-hours'             => 'required|integer',
            Model::REL_USER         => ['required', new HasOne(User::TABLE_NAME)],
        ];

        // if not admin, can only create works for himself
        if (!$is_admin) {
            $validator[Model::REL_USER . '.id'] = 'required|in:' . request()->user()->$id_user;
        }

        return $validator;
    }

    /**
     * Get query parameter validation rules.
     *
     * @return array
     */
    protected function queryRules(): array
    {
        return [
            //
        ];
    }
}
