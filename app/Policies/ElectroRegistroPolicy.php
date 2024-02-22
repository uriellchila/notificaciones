<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\ElectroRegistro;
use App\Models\User;

class ElectroRegistroPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo ElectroRegistro');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, ElectroRegistro $electroregistro): bool
    {
        return $user->checkPermissionTo('ver ElectroRegistro');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear ElectroRegistro');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, ElectroRegistro $electroregistro): bool
    {
        return $user->checkPermissionTo('actualizar ElectroRegistro');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, ElectroRegistro $electroregistro): bool
    {
        return $user->checkPermissionTo('eliminar ElectroRegistro');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, ElectroRegistro $electroregistro): bool
    {
        return $user->checkPermissionTo('restaurar ElectroRegistro');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, ElectroRegistro $electroregistro): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion ElectroRegistro');
    }
}
