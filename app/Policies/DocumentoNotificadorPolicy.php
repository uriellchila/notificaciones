<?php

namespace App\Policies;

use Illuminate\Auth\Access\Response;
use App\Models\DocumentoNotificador;
use App\Models\User;

class DocumentoNotificadorPolicy
{
    /**
     * Determine whether the user can view any models.
     */
    public function viewAny(User $user): bool
    {
        return $user->checkPermissionTo('ver-solo DocumentoNotificador');
    }

    /**
     * Determine whether the user can view the model.
     */
    public function view(User $user, DocumentoNotificador $documentonotificador): bool
    {
        return $user->checkPermissionTo('ver DocumentoNotificador');
    }

    /**
     * Determine whether the user can create models.
     */
    public function create(User $user): bool
    {
        return $user->checkPermissionTo('crear DocumentoNotificador');
    }

    /**
     * Determine whether the user can update the model.
     */
    public function update(User $user, DocumentoNotificador $documentonotificador): bool
    {
        return $user->checkPermissionTo('actualizar DocumentoNotificador');
    }

    /**
     * Determine whether the user can delete the model.
     */
    public function delete(User $user, DocumentoNotificador $documentonotificador): bool
    {
        return $user->checkPermissionTo('eliminar DocumentoNotificador');
    }

    /**
     * Determine whether the user can restore the model.
     */
    public function restore(User $user, DocumentoNotificador $documentonotificador): bool
    {
        return $user->checkPermissionTo('restaurar DocumentoNotificador');
    }

    /**
     * Determine whether the user can permanently delete the model.
     */
    public function forceDelete(User $user, DocumentoNotificador $documentonotificador): bool
    {
        return $user->checkPermissionTo('forzar-eliminacion DocumentoNotificador');
    }
}
