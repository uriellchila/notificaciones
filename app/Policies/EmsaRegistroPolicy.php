<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\EmsaRegistro;
use App\Models\User;

class EmsaRegistroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo EmsaRegistro');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, EmsaRegistro $emsaregistro): bool
    {
        return $user->checkPermissionTo('ver EmsaRegistro');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear EmsaRegistro');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, EmsaRegistro $emsaregistro): bool
    {
        return $user->checkPermissionTo('actualizar EmsaRegistro');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, EmsaRegistro $emsaregistro): bool
    {
        return $user->checkPermissionTo('eliminar EmsaRegistro');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, EmsaRegistro $emsaregistro): bool
    {
        return $user->checkPermissionTo('restaurar EmsaRegistro');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, EmsaRegistro $emsaregistro): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion EmsaRegistro');
    }
}
