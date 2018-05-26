<?php

namespace App\Policies;

use App\User;
use App\Model\Approve_List;
use Illuminate\Auth\Access\HandlesAuthorization;

class approve
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the approve_ list.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Approve_List  $approveList
     * @return mixed
     */
    public function view(User $user, Approve_List $approveList)
    {
        //
    }

    /**
     * Determine whether the user can create approve_ lists.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the approve_ list.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Approve_List  $approveList
     * @return mixed
     */
    public function update(User $user, Approve_List $approveList)
    {
        return $approveList<>null;
    }

    /**
     * Determine whether the user can delete the approve_ list.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Approve_List  $approveList
     * @return mixed
     */
    public function delete(User $user, Approve_List $approveList)
    {
        return $approveList<>null;
    }
}
