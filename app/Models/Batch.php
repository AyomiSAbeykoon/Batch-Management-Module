<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;
use OwenIt\Auditing\Auditable as AuditableTrait;

class Batch extends Model implements Auditable
{
    use HasFactory;
    use AuditableTrait;



    protected $fillable = [
        'label',
        'intake_start_date',
        'intake_end_date',
        'is_extended',
        'extended_date'
    ];

    protected $auditInclude = ['label', 'intake_start_date','intake_end_date','is_extended','extended_date'];
}
