<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\SubTipoNotificacion;
use App\Models\User;

class SubTipoNotificacionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo SubTipoNotificacion');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, SubTipoNotificacion $subtiponotificacion): bool
    {
        return $user->checkPermissionTo('ver SubTipoNotificacion');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear SubTipoNotificacion');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, SubTipoNotificacion $subtiponotificacion): bool
    {
        return $user->checkPermissionTo('actualizar SubTipoNotificacion');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, SubTipoNotificacion $subtiponotificacion): bool
    {
        return $user->checkPermissionTo('eliminar SubTipoNotificacion');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, SubTipoNotificacion $subtiponotificacion): bool
    {
        return $user->checkPermissionTo('restaurar SubTipoNotificacion');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, SubTipoNotificacion $subtiponotificacion): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion SubTipoNotificacion');
    }
}
