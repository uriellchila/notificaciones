<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\Contribuyente;
use App\Models\User;

class ContribuyentePolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo Contribuyente');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, Contribuyente $contribuyente): bool
    {
        return $user->checkPermissionTo('ver Contribuyente');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear Contribuyente');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, Contribuyente $contribuyente): bool
    {
        return $user->checkPermissionTo('actualizar Contribuyente');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, Contribuyente $contribuyente): bool
    {
        return $user->checkPermissionTo('eliminar Contribuyente');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, Contribuyente $contribuyente): bool
    {
        return $user->checkPermissionTo('restaurar Contribuyente');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, Contribuyente $contribuyente): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion Contribuyente');
    }
}
