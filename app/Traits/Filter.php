<?php

namespace App\Traits;

trait Filter
{
    public function filterQuery($query, $operator, $field)
    {
        foreach ($operator as $key => $value) {
            if ($key === 'lt') {
                $query = $query->where($field, '<', $value);
            } elseif ($key === 'lte') {
                $query = $query->where($field, '<=', $value);
            } elseif ($key === 'gte') {
                $query = $query->where($field, '>=', $value);
            } elseif ($key === 'gt') {
                $query = $query->where($field, '>', $value);
            } else {
                // allow comma separated filters for non-ranged operators ('eq', 'like')
                $splitArr = explode(',', $value);
                foreach ($splitArr as $el) {
                    if ($key === 'eq') {
                        $query = $query->where($field, '=', $el);
                    } elseif ($key === 'like') {
                        $query = $query->where($field, 'LIKE', '%' . $el . '%');
                    }
                }
            }
        }
    }
}
