<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Cache;

class Term extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_terms';

    public function getTerms($type, $key = 'name', $value = 'value')
    {
        return Cache::remember($type, 10, function () use ($type, $key, $value) {
            $method = str_replace('.', '', $type);

            if (method_exists($this, $method)) {
                return $this->$method($type);
            }

            return $this->where(['type' => $type])
                ->orderBy('sort', 'desc')
                ->orderBy('name')
                ->lists($value, $key);
        });
    }

}
