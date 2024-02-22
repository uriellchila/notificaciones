<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\MotivoDevolucion;
use App\Models\User;

class MotivoDevolucionPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo MotivoDevolucion');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, MotivoDevolucion $motivodevolucion): bool
    {
        return $user->checkPermissionTo('ver MotivoDevolucion');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear MotivoDevolucion');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, MotivoDevolucion $motivodevolucion): bool
    {
        return $user->checkPermissionTo('actualizar MotivoDevolucion');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, MotivoDevolucion $motivodevolucion): bool
    {
        return $user->checkPermissionTo('eliminar MotivoDevolucion');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, MotivoDevolucion $motivodevolucion): bool
    {
        return $user->checkPermissionTo('restaurar MotivoDevolucion');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, MotivoDevolucion $motivodevolucion): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion MotivoDevolucion');
    }
}
