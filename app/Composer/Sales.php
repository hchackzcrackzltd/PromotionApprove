<?php
namespace App\Composer;

use Illuminate\View\View;
use App\Model\Masterdata\Sales as sldb;
use App\Model\Masterdata\Employee;
use App\Model\Masterdata\Approve;

class Sales{
  public function compose(View $view)
  {
    $view->with(['sales'=>sldb::all(),'applist'=>Approve::all()]);
  }
}
