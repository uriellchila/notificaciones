<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DevolucionDocumento;
use App\Models\User;

class DevolucionDocumentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo DevolucionDocumento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DevolucionDocumento $devoluciondocumento): bool
    {
        return $user->checkPermissionTo('ver DevolucionDocumento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear DevolucionDocumento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DevolucionDocumento $devoluciondocumento): bool
    {
        return $user->checkPermissionTo('actualizar DevolucionDocumento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DevolucionDocumento $devoluciondocumento): bool
    {
        return $user->checkPermissionTo('eliminar DevolucionDocumento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DevolucionDocumento $devoluciondocumento): bool
    {
        return $user->checkPermissionTo('restaurar DevolucionDocumento');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DevolucionDocumento $devoluciondocumento): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion DevolucionDocumento');
    }
}
