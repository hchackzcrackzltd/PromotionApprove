<?php

namespace App\Policies;

use App\User;
use App\Model\Pro;
use Illuminate\Auth\Access\HandlesAuthorization;

class promotion
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the pro.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Pro  $pro
     * @return mixed
     */
    public function view(User $user, Pro $pro)
    {
        //
    }

    /**
     * Determine whether the user can create pros.
     *
     * @param  \App\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the pro.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Pro  $pro
     * @return mixed
     */
    public function update(User $user, Pro $pro)
    {
        //
    }

    /**
     * Determine whether the user can delete the pro.
     *
     * @param  \App\User  $user
     * @param  \App\App\Model\Pro  $pro
     * @return mixed
     */
    public function delete(User $user, Pro $pro)
    {
      if ($user->Authorize_Main()->first()->isadmin) {
        return $pro->status==='NQ';
      }else {
        return $pro->status==='NQ'&&$pro->createby===$user->username;
      }
    }
}
