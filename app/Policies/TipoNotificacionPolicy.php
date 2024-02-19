<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TipoNotificacion;
use App\Models\User;

class TipoNotificacionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo TipoNotificacion');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TipoNotificacion $tiponotificacion): bool
    {
        return $user->checkPermissionTo('ver TipoNotificacion');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear TipoNotificacion');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TipoNotificacion $tiponotificacion): bool
    {
        return $user->checkPermissionTo('actualizar TipoNotificacion');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TipoNotificacion $tiponotificacion): bool
    {
        return $user->checkPermissionTo('eliminar TipoNotificacion');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TipoNotificacion $tiponotificacion): bool
    {
        return $user->checkPermissionTo('restaurar TipoNotificacion');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TipoNotificacion $tiponotificacion): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion TipoNotificacion');
    }
}
