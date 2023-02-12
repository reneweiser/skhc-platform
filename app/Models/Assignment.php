<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class Assignment extends Pivot
{
    protected $table = 'assignments';
}
