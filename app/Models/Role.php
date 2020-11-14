<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    use HasFactory;

    const AVAILABLE_ROLES = [
        'regular-user',
        'user-manager',
        'admin',
    ];

    /**
     * Table name
     */
    const TABLE_NAME = 'roles';

    /**
     * Primary key
     */
    const FIELD_ID = 'id_role';

    /**
     * Field name
     */
    const FIELD_NAME = 'name';

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
    ];

    /**
     * Get the users associated with the role.
     */
    public function users()
    {
        return $this->belongsToMany(User::class, 'roles_users', self::FIELD_ID, User::FIELD_ID);
    }
}
