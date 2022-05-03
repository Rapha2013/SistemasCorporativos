<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MovementType extends Model
{
    use HasFactory;

    /**
     * the Id associated with the partnert 
     *
     * @var int
     */

    public $timestamps = false;

    /**
     * The table associated with the model.
     *
     * @var string
     */

    protected $table = 'movement_type';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'id',
        'description',
        'type'
    ];
}
