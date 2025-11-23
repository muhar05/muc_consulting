<?php

namespace App\Models\marketing;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServiceusedModel extends Model
{
    use HasFactory;
    protected $connection = 'mysql_marketing';
    protected $table = 'serviceused';

    // Tambahkan field yang boleh diisi massal
    protected $fillable = [
        'proposal_id',
        'service_name',
        'status',
        'created_at',
        'updated_at',
    ];

    public function timesheets()
    {
        return $this->hasMany(\App\Models\activity\TimesheetModel::class, 'serviceused_id');
    }
}