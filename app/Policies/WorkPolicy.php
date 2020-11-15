<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Work;
use Illuminate\Auth\Access\HandlesAuthorization;

class WorkPolicy
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
     * Determine whether the user can access index method of the model.
     *
     * @param User $authUser
     * @return mixed
     */
    public function index(User $authUser)
    {
        $roles = $authUser->roles()->get();
        // only admin can access work resource
        return $roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can access create method of the model.
     *
     * @param User $authUser
     * @return mixed
     */
    public function create(User $authUser)
    {
        $roles = $authUser->roles()->get();
        // only regular user and admin can access work resource
        return $roles->contains('name', 'regular-user') || $roles->contains('name', 'admin');
    }

    /**
     * Determine whether the user can access read, update and delete methods of the model.
     *
     * @param User $authUser
     * @param Work $work
     * @return mixed
     */
    public function readUpdateDelete(User $authUser, Work $work)
    {
        $roles = $authUser->roles()->get();
        $id = User::FIELD_ID;
        // only admin can access work resource (unless owner)
        return $roles->contains('name', 'admin') || $authUser->$id === $work->$id;
    }
}
