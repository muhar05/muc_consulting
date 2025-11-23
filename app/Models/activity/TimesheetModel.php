<?php

namespace App\Models\activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetModel extends Model
{
    use HasFactory;
    protected $table = 'timesheet';
    protected $connection = 'mysql_activity'; // <-- tambahkan baris ini
    protected $fillable = [
        'date',
        'timestart',
        'timefinish',
        'description',
        'employees_id',
        'serviceused_id',
    ];
    public $timestamps = false; // <-- tambahkan baris ini

    public function employee()
    {
        return $this->belongsTo(\App\Models\hrd\EmployeesModel::class, 'employees_id');
    }
}