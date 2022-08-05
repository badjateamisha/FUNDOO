<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Foundation\Auth\create as Authenticatable;
use Illuminate\Contracts\Auth\MustVerifyEmail;


class Contact extends Model
{
    use HasFactory;
    protected $fillable = [
        'UserName',
        'Email',
        'Password',
        'MobileNumber',
        'Address',
    ];
}
