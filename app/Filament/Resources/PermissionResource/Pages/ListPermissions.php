<?php

namespace App\Filament\Resources\PermissionResource\Pages;

use App\Filament\Resources\PermissionResource;
use Filament\Actions;
use Filament\Notifications\Notification;
use Filament\Resources\Pages\ListRecords;
use Filament\Support\Colors\Color;
use Filament\Actions\Action;
use Illuminate\Support\Str;
use Spatie\ModelInfo\ModelFinder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class ListPermissions extends ListRecords
{
    protected static string $resource = PermissionResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
            Action::make('scan')
                ->label('Skenovat')
                ->color(Color::Green)
                ->action(function() {
                    if (!auth()->user()->can('create_permissions') && !auth()->user()->hasRole('admin')) {
                        abort(403);
                    }
                    $admin = Role::where('name', '=', 'admin')->firstOrFail();
                    $models = ModelFinder::all();
                    $models->push(Role::class);
                    $models->push(Permission::class);
                    $permissions = collect();
                    foreach ($models as $model) {
                        $modelSlug = Str::camel(app($model)->getTable());
                        $permissions->push(Permission::firstOrCreate(['name' => 'viewAny_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'view_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'create_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'update_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'delete_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'restore_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'forceDelete_' . $modelSlug, 'guard_name' => 'web']));
                        $permissions->push(Permission::firstOrCreate(['name' => 'reorder_' . $modelSlug, 'guard_name' => 'web']));
                    }
                    $admin->permissions()->syncWithoutDetaching($permissions);
                    Notification::make()
                        ->title('Oprávnění byla vytvořena')
                        ->success()
                        ->send();
                    return redirect()->back();
                }),
        ];
    }
}
