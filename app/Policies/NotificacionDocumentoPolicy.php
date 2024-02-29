<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\NotificacionDocumento;
use App\Models\User;

class NotificacionDocumentoPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo NotificacionDocumento');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, NotificacionDocumento $notificaciondocumento): bool
    {
        return $user->checkPermissionTo('ver NotificacionDocumento');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear NotificacionDocumento');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, NotificacionDocumento $notificaciondocumento): bool
    {
        return $user->checkPermissionTo('actualizar NotificacionDocumento');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, NotificacionDocumento $notificaciondocumento): bool
    {
        return $user->checkPermissionTo('eliminar NotificacionDocumento');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, NotificacionDocumento $notificaciondocumento): bool
    {
        return $user->checkPermissionTo('restaurar NotificacionDocumento');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, NotificacionDocumento $notificaciondocumento): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion NotificacionDocumento');
    }
}
