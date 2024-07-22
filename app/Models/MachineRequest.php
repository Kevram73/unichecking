<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MachineRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        "request_code",
        "dev_id",
        "dev_model",
        "token",
        "time",
        "body_data"
    ];
}
