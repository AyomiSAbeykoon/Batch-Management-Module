<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Student extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;


    protected $fillable = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'nic',
        'gender',
        'dob',
        'address',
        'batch_id',
    ];

    public function batch()
    {
        return $this->belongsTo('App\Models\Batch', 'batch_id', 'id');
    }

    protected $auditInclude = [
        'first_name',
        'last_name',
        'email',
        'phone_number',
        'nic',
        'gender',
        'dob',
        'address',
        'batch_id',
    ];
}
