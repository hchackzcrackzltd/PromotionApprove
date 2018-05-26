<?php
namespace App\Composer;

use Illuminate\View\View;

/**
 *
 */
class Authorizes
{

  function compose(View $view)
  {
    $view->with(['auth_name'=>['No Authorize','Full Authorize'],'auth2_name'=>['Read Only','Full Authorize'],'function_name'=>['Promotion','Approve','Setting']]);
  }
}
