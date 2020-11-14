<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use phpDocumentor\Reflection\Types\Collection;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, Filter;

    /**
     * Table name
     */
    const TABLE_NAME = 'users';

    /**
     * Primary key
     */
    const FIELD_ID = 'id_user';

    /**
     * Field name
     */
    const FIELD_NAME = 'name';

    /**
     * Field name
     */
    const FIELD_EMAIL = 'email';

    /**
     * Field name
     */
    const FIELD_EMAIL_VERIFIED_AT = 'email_verified_at';

    /**
     * Field name
     */
    const FIELD_PASSWORD = 'password';

    /**
     * Field name
     */
    const FIELD_REMEMBER_TOKEN = 'remember_token';

    /**
     * Relationship name
     */
    const REL_WORKS = 'works';

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = self::TABLE_NAME;

    /**
     * The primary key associated with the table.
     *
     * @var string
     */
    protected $primaryKey = self::FIELD_ID;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        self::FIELD_NAME,
        self::FIELD_EMAIL,
        self::FIELD_PASSWORD,
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        self::FIELD_PASSWORD,
        self::FIELD_REMEMBER_TOKEN,
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        self::FIELD_EMAIL_VERIFIED_AT => 'datetime',
    ];

    /**
     * Get the works associated with the user.
     */
    public function works()
    {
        return $this->hasMany(Work::class, self::FIELD_ID, Work::FIELD_ID_USER);
    }

    /**
     * Get the roles associated with the user.
     */
    public function roles()
    {
        return $this->belongsToMany(Role::class, 'roles_users', self::FIELD_ID, Role::FIELD_ID);
    }

    /**
     * Filtering with scopes
     * @param $query
     * @param $operator
     * @return Collection
     */
    public function scopeName($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_NAME);
        return $query;
    }

    public function scopeEmail($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_EMAIL);
        return $query;
    }
}
