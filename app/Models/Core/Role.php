<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Permission\Models\Role as ModelsRole;

#[Fillable([
    'name',
    'guard_name',
])]

class Role extends ModelsRole
{
    use LogsActivity;
}
