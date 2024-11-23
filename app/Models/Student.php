<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Student extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'students';

    /**
     * The primary key for the model.
     *
     * @var string
     */
    protected $primaryKey = 'reg_number';

    /**
     * Indicates if the primary key is non-incrementing or non-integer.
     *
     * @var bool
     */
    public $incrementing = false;

    /**
     * The data type of the primary key.
     *
     * @var string
     */
    protected $keyType = 'string';

    /**
     * Indicates if the model should use timestamps.
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'reg_number',
        'first_name',
        'last_name',
        'middle_name',
        'gender',
        'level',
        'date_of_birth',
        'religion',
        'nationality',
        'state_of_origin',
        'lga_of_origin',
        'state_of_residence',
        'lga_of_residence',
        'permanent_address',
        'residential_address',
        'guardian_name',
        'guardian_phone_number',
        'guardian_email',
        'passport_url',
        'created_at',
        'version',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'date_of_birth' => 'date',
        'created_at' => 'datetime',
    ];
}
