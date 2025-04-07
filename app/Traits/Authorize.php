<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Spatie\Permission\Models\Permission;
use Str;

trait Authorize {
    public static function can(string $action, ?Model $record = null): bool
    {
        $model = app(get_class())::getModel();
        if ($model === null) {
            return true;
        }
        $slug = Str::camel(app($model)->getTable());
        if ($slug == "users" && $action == "update" && $record !== null && $record->id === auth()->user()->id) {
            return true;
        }
        if (($slug == "permissions" || $slug == "roles" || $slug == "users") && auth()->user()->hasRole('admin')) {
            return true;
        }
        $permission = Permission::firstWhere('name', '=', $action . '_' . $slug);
        return $permission !== null && auth()->user()->hasPermissionTo($permission);
    }
}
