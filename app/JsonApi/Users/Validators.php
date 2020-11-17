<?php

namespace App\JsonApi\Users;

use App\Models\User as Model;
use App\Models\Work;
use CloudCreativity\LaravelJsonApi\Contracts\Validation\ValidatorInterface;
use CloudCreativity\LaravelJsonApi\Rules\HasMany;
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
        Model::REL_WORKS,
    ];

    /**
     * The sort field names a client is allowed send.
     *
     * @var string[]|null
     *      the allowed fields, an empty array for none allowed, or null to allow all fields.
     */
    protected $allowedSortParameters = [
        Model::FIELD_NAME,
        Model::FIELD_EMAIL,
    ];

    /**
     * The filters a client is allowed send.
     *
     * @var string[]|null
     *      the allowed filters, an empty array for none allowed, or null to allow all.
     */
    protected $allowedFilteringParameters = [
        Model::FIELD_NAME,
        Model::FIELD_EMAIL,
    ];

    public function update($record, array $document): ValidatorInterface
    {
        $validator = parent::update($record, $document);

        $validator->sometimes('password_confirmation', 'required_with:' . Model::FIELD_PASSWORD . '|same:' . Model::FIELD_PASSWORD, function ($input) {
            return isset($input['password']);
        });

        return $validator;
    }

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
        $id = Model::FIELD_ID;
        $table = Model::TABLE_NAME;
        $uniqueExceptString = $record ? ",{$record->$id},{$id}" : '';
        $is_admin = request()->user()->roles->contains('name', 'admin');

        $rules = [
            Model::FIELD_NAME     => 'required|string',
            Model::FIELD_EMAIL    => 'required|email|unique:' . $table . ',' . Model::FIELD_EMAIL . $uniqueExceptString,
            Model::FIELD_PASSWORD => [$record ? 'filled' : 'required', 'string'],
            Model::REL_WORKS      => [new HasMany(Work::TABLE_NAME)],
        ];

        if (!$record) {
            $rules['password_confirmation'] = 'required_with:' . Model::FIELD_PASSWORD . '|same:' . Model::FIELD_PASSWORD;
        }

        return $rules;
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
