<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\Models\Coinwithdraw;
use App\Models\Cryptotransaction;
use App\Models\Trade;
use App\Models\Tradepair;
use App\Models\Commission;
use Validator;

class HistroyController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware(['auth','twofa','kyc']);
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return view('histroy');
    }

    public function trade()
    {
        $uid = Auth::id();        
        $listPairs = Tradepair::where([['active', '=', 1],['is_spot', '=', 1],])->orderBy('id', 'asc')->get();
        $historys = Trade::where(['uid' => $uid])->paginate(15);
        return view('history.trade',['listPairs' => $listPairs,'historys' => $historys,'Pair'=>'', 'type'=>" " ,'start_date'=>"",'end_date'=>'']);
    }
    public function deposit()
    {
        $uid= Auth::id();
        $coinsList = Commission::get();
        $historys = Cryptotransaction::listView($uid);
        return view('history.deposit',['coinsList' => $coinsList,'historys' => $historys]);
    }
    public function withdraw()
    {
        $uid= Auth::id();
        $coinsList = Commission::get();
        $historys = Coinwithdraw::listView($uid);
        return view('history.withdraw',['coinsList' => $coinsList,'historys' => $historys]);
    }
    public function tradeSearch(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'pair'      => 'nullable|alpha_dash|max:10',
            'type'      => 'required|in:Buy,Sell,All',
            'startdate' => 'nullable|date',
            'enddate'   => 'nullable|date',
        ]);
        $uid = Auth::id();        
        $listPairs = Tradepair::where('active',1)->orderBy('id', 'asc')->get();
        $whereType = false;
        $wherePair = false;
        if(isset($request->type)){
            $type = $request->type;
            if($type != 'All'){
                $whereType = true;
            }
        }else{
            $type = 'All';
        }
        
        if(isset($request->startdate) && isset($request->enddate)){
            $start = date('Y-m-d',strtotime($request->startdate));
            $end   = date('Y-m-d',strtotime($request->enddate));
            $where = true;
        }else{
            $where = false;
            $start = "";
            $end   = "";
        }
        $pair = 1;
        if(isset($request->pair)){
            if($request->pair != 'All'){
                $pairsplit = explode('_', $request->pair);
                $tradepair = Tradepair::where([
                    ['coinone', '=', $pairsplit[0]],
                    ['cointwo', '=', $pairsplit[1]],
                    ['active', '=', 1]
                ])->orderBy('id', 'desc')->first();
                $wherePair = true;
                $pair = $tradepair->id;
            }
        }
        //For remain input after submit SearchBox  
            $Pair=$request->pair;
            $type=$request->type;
            $start_date=$request->startdate;
            $end_date=$request->enddate;
            
        $historys = Trade::where(['uid' => $uid])
        ->when($where, function ($query1) use ($start,$end) {
            return $query1->whereBetween('created_at', array($start.' 00:00:00', $end.' 23:59:59'));
        })
        ->when($whereType, function ($query2) use ($type) {
            return $query2->where('trade_type', $type);
        })
        ->when($wherePair, function ($query3) use ($pair) {
            return $query3->where('pair', $pair);
        })->paginate(15);
        return view('history.trade',['listPairs' => $listPairs,'historys' => $historys,'historys' => $historys ,'Pair'=>$Pair ,'type'=>$type,'start_date'=>$start_date,'end_date'=>$end_date]);
    }
}
