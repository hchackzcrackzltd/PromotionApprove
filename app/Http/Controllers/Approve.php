<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Model\Masterdata\Approve as appdb;
use App\Model\Pro;
use App\Model\Approve_List;
use App\Model\Masterdata\emp_proapp;
use App\Mail\approve as mapp;
use App\Mail\alert_approve;
use Illuminate\Support\Facades\Mail;

class Approve extends Controller
{
    public function create(Pro $pro)
    {
      if (Auth::user()->load('Authorize_Main')->Authorize_Main) {
        if (Auth::user()->load('Authorize_Main.approve_list1')->Authorize_Main->approve_list1->count()) {
          foreach (Auth::user()->load('Authorize_Main.approve_list1')->Authorize_Main->approve_list1 as $value) {
            Approve_List::create(['pro_id'=>$pro->id,'user_id'=>$value->user_id,'seq'=>$value->seq,'status'=>0,'app_id'=>$value->approves_id,
            'name'=>$value->name,'email'=>$value->email]);
          }
          $this->nextapp($pro);
        }else {
        $pro->update(['approve'=>1,'status'=>'SC']);
        }
      }
      else {
        $pro->update(['approve'=>1,'status'=>'SC']);
      }
    }

    public function refactor(appdb $approve)
    {
      $item=[];
        $data1=Approve_List::where('app_id',$approve->id)->get();
        $approve_list_new=$approve->load('approve1');
        Approve_List::where('app_id',$approve->id)->whereIn('status',[0,1])->delete();
        foreach (Pro::where('approve',0)->get() as $value) {
          if ($data1->where('pro_id',$value->id)->where('app_id',$approve->id)->count()) {
          $approved=$data1->where('pro_id',$value->id)->where('seq',$data1->where('pro_id',$value->id)->min('seq'))->where('status',1);
          if ($approved->count()===0) {
              $max3=$data1->where('pro_id',$value->id)->where('status',2)->max('seq');
              if ($approve_list_new->approve1->where('seq','>',$max3)->count()===0) {
                $value->update(['approve'=>1,'status'=>'SC']);
              }else {
                foreach ($approve_list_new->approve1->where('seq','>',$max3) as $value3) {
                  $item[]=Approve_List::create(['pro_id'=>$value->id,'user_id'=>$value3->user_id,
                  'seq'=>$value3->seq,'status'=>0,'app_id'=>$approve->id,'name'=>$value3->name,'email'=>$value3->email]);
                }
                $this->nextapp($value);
              }
          }else {
            foreach ($approve->load('approve1')->approve1 as $value2) {
              $item[]=Approve_List::create(['pro_id'=>$value->id,'user_id'=>$value2->user_id,
              'seq'=>$value2->seq,'status'=>0,'app_id'=>$approve->id,'name'=>$value2->name,'email'=>$value2->email]);
            }
            $this->nextapp($value);
          }
          }
        }
        foreach($item as $value){
          Mail::to($value)->send(new mapp(Pro::findOrFail($value->pro_id)));
        }
    }

    public function nextapp(Pro $Pro)
    {
      $data=$Pro->load('list_approve')->list_approve;
        $min=$data->where('status',0)->min('seq');
        $Pro->list_approve()->where(['status'=>0,'seq'=>$min])->update(['status'=>1]);
        foreach ($Pro->load(['list_approve'=>function($query){$query->where('status',1);}])->list_approve as $value) {
          Mail::to($value)->send(new mapp($Pro));
        }
    }

    public function currentapp(Pro $Pro){
      $Pro->update(['status'=>'WP']);
      Approve_List::where(['pro_id'=>$Pro->id,'user_id'=>Auth::user()->username])->update(['status'=>2]);
      foreach (Approve_List::where(['pro_id'=>$Pro->id,'status'=>1])->get() as $value) {
        Approve_List::where(['pro_id'=>$Pro->id,'user_id'=>$value->user_id])->update(['status'=>3,'remark'=>'Approve By'.Auth::user()->name]);
      }
      Mail::to(emp_proapp::findOrFail($Pro->createby))->send(new alert_approve($Pro));
      $this->nextapp($Pro);
      $check_app=Approve_List::where(['pro_id'=>$Pro->id,'status'=>1])->get();
      if($check_app->count()===0){
        $Pro->update(['approve'=>1,'status'=>'SC']);
      }
    }
}
