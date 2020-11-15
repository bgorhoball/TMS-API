<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine whether the user can access index and create method of the model.
     *
     * @param User $authUser
     * @return mixed
     */
    public function indexCreate(User $authUser)
    {
        $roles = $authUser->roles()->get();
        // only user manager and admin can access user resource
        return $roles->contains('name', 'user-manager') || $roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can access read, update and delete methods of the model.
     *
     * @param User $authUser
     * @param User $user
     * @return mixed
     */
    public function readUpdateDelete(User $authUser, User $user)
    {
        $roles = $authUser->roles()->get();
        $id = User::FIELD_ID;
        // only user manager and admin can access user resource (unless owner)
        return $roles->contains('name', 'user-manager') || $roles->contains('name', 'admin') || $authUser->$id === $user->$id;
    }

    /**
     * Determine whether the user can crud relationships.
     *
     * @param User $authUser
     * @param User $user
     * @return mixed
     */
    public function crudRelationship(User $authUser, User $user)
    {
        $roles = $authUser->roles()->get();
        $id = User::FIELD_ID;
        // only admin can access user works (unless owner)
        return $roles->contains('name', 'admin') || $authUser->$id === $user->$id;
    }
}
