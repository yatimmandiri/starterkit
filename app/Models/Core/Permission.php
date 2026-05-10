<?php

namespace App\Models\Core;

use Illuminate\Database\Eloquent\Attributes\Fillable;
use Spatie\Activitylog\Models\Concerns\LogsActivity;
use Spatie\Permission\Models\Permission as ModelsPermission;

#[Fillable([
    'name',
    'guard_name',
])]

class Permission extends ModelsPermission
{
    use LogsActivity;
}
