<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $table = 'settings';
    protected $fillable = [
        'site_name',
        'currency',
        'logo',
        'favicon',
        'contact_number',
        'contact_email',
        'address',
        'facebook',
        'twitter',
        'instagram',
        'youtube',
        'whatsapp',
        'maintenance_mode',
        'maintenance_message',
        'team_name',
        'copyright_text'
    ];
}
