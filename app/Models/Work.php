<?php

namespace App\Models;

use App\Traits\Filter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use phpDocumentor\Reflection\Types\Collection;

class Work extends Model
{
    use HasFactory, Filter;

    /**
     * Table name
     */
    const TABLE_NAME = 'works';

    /**
     * Primary key
     */
    const FIELD_ID = 'id_work';

    /**
     * Field name
     */
    const FIELD_ID_USER = 'id_user';

    /**
     * Field name
     */
    const FIELD_DETAILS = 'details';

    /**
     * Field name
     */
    const FIELD_DATE = 'date';

    /**
     * Field name
     */
    const FIELD_HOURS = 'hours';

    /**
     * Field name
     */
    const FIELD_EST_HOURS = 'est_hours';

    /**
     * Relationship name
     */
    const REL_USER = 'user';

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
        self::FIELD_ID_USER,
        self::FIELD_DETAILS,
        self::FIELD_DATE,
        self::FIELD_HOURS,
        self::FIELD_EST_HOURS,
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        self::FIELD_DATE,
    ];

    /**
     * Get the user associated with the work.
     */
    public function user()
    {
        return $this->belongsTo(User::class, self::FIELD_ID_USER, User::FIELD_ID);
    }

    /**
     * Filtering with scopes
     * @param $query
     * @param $operator
     * @return Collection
     */
    public function scopeDetails($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_DETAILS);
        return $query;
    }

    public function scopeDate($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_DATE);
        return $query;
    }

    public function scopeHours($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_HOURS);
        return $query;
    }

    public function scopeEstHours($query, $operator)
    {
        $this->filterQuery($query, $operator, self::FIELD_EST_HOURS);
        return $query;
    }
}
