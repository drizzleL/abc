<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AuditReason extends Model
{
    protected $connection = 'zhaoshou-3';
    protected $table = 'hi_audit_reason';
    protected $fillable = ['type', 'belong', 'reason'];
}
