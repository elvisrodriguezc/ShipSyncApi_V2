<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

class Document extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'symbol',
        'name',
        'status',
    ];

    /**
     * Accessor for symbol - maps to code column.
     */
    public function getSymbolAttribute()
    {
        return $this->attributes['code'] ?? null;
    }

    /**
     * Mutator for symbol - maps to code column.
     */
    public function setSymbolAttribute($value)
    {
        $this->attributes['code'] = $value;
    }

    /**
     * Override newEloquentBuilder to intercept queries using 'symbol' and map them to 'code'.
     */
    public function newEloquentBuilder($query)
    {
        return new class($query) extends Builder {
            public function where($column, $operator = null, $value = null, $boolean = 'and')
            {
                if ($column === 'symbol') {
                    $column = 'code';
                }
                return parent::where($column, $operator, $value, $boolean);
            }
        };
    }
}
