<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AnyFile extends Model
{
    use HasFactory;

    public function getDownloadLink () {
        return '/download/' . $this->id;
    }
}
