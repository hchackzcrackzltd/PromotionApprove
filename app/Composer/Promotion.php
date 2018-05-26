<?php
namespace App\Composer;

use Illuminate\View\View;
use App\Model\Masterdata\Promotion as prodb;
use App\Model\Masterdata\Expense;
use App\Model\Masterdata\OCRD;

class Promotion{

public $pro;

  public function __construct(prodb $pro)
  {
    $this->pro=$pro;
  }

  public function compose(View $view)
  {
    $view->with(['promotion'=>$this->pro->inactive()->selectRaw("code as [id],name")->get(),
    'expense'=>Expense::inactive()->get(),'customer'=>OCRD::all()]);
  }
}
