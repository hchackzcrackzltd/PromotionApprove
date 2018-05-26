<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use App\Model\Authorize_Main;
use Illuminate\Support\Facades\Log;

class authorize
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function promotionview(User $user,Authorize_Main $atr)
    {
      if ($user->Authorize_Main()->first()->isadmin) {
        return true;
      }
      return $atr->authorize()->Where(['funct_id'=>0,'permit'=>0])->orWhere(['funct_id'=>1,'permit'=>1])->count()>0;
    }

    public function promotion(User $user,Authorize_Main $atr)
    {
      if ($user->Authorize_Main()->first()->isadmin) {
        return true;
      }
      return $atr->authorize()->where(['funct_id'=>0,'permit'=>1])->count()>0;
    }

    public function approve(User $user,Authorize_Main $atr)
    {
      if ($user->Authorize_Main()->first()->isadmin) {
        return true;
      }
      return $atr->authorize()->where(['funct_id'=>1,'permit'=>1])->count()>0;
    }

    public function setting(User $user,Authorize_Main $atr)
    {
      if ($user->Authorize_Main()->first()->isadmin) {
        return true;
      }
      return $atr->authorize()->where(['funct_id'=>2,'permit'=>1])->count()>0;
    }
}
