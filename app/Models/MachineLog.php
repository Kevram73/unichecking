<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineLog extends Model
{
    use HasFactory;

    protected $fillable = [
        "user_id",
        "time",
        "verify_mode",
        "io_mode",
        "in_out",
        "door_mode",
        "log_photo",
        'device_id'
    ];
}
