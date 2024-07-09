<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    use HasFactory;

    protected $fillable = [
        "emp_code",
        "punch_time",
        "punch_state",
        "verify_type",
        "work_code",
        "terminal_sn",
        "terminal_alias",
        "area_alias",
        "longitude",
        "latitude",
        "gps_location",
        "mobile",
        "source",
        "purpose",
        "crc",
        "is_attendance",
        "reserved",
        "upload_time",
        "sync_status",
        "sync_time",
        "temperature",
        "mask_flag",
        "company",
        "emp",
        "terminal"
    ];
}
