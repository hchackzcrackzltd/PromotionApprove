<?php
namespace App\Composer;

use Illuminate\View\View;
use App\Model\Masterdata\OITM;

class Item{

public $oitm;

  public function __construct(OITM $oitm)
  {
    $this->oitm=$oitm;
  }

  public function compose(View $view)
  {
    $view->with('item',$this->oitm->all());
  }
}
