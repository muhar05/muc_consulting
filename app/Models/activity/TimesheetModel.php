<?php

namespace App\Models\activity;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TimesheetModel extends Model
{
    use HasFactory;
    protected $table = 'timesheet';
    protected $connection = 'mysql_activity'; // <-- tambahkan baris ini
}