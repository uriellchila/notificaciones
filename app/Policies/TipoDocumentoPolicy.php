<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\TipoDocumento;
use App\Models\User;

class TipoDocumentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo TipoDocumento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, TipoDocumento $tipodocumento): bool
    {
        return $user->checkPermissionTo('ver TipoDocumento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear TipoDocumento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, TipoDocumento $tipodocumento): bool
    {
        return $user->checkPermissionTo('actualizar TipoDocumento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, TipoDocumento $tipodocumento): bool
    {
        return $user->checkPermissionTo('eliminar TipoDocumento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, TipoDocumento $tipodocumento): bool
    {
        return $user->checkPermissionTo('restaurar TipoDocumento');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, TipoDocumento $tipodocumento): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion TipoDocumento');
    }
}
