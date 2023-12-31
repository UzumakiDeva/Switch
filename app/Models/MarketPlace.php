<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MarketPlace extends Model
{
    public static function createTrade($uid,$type,$orderId,$pairID,$price,$volume,$total,$fee,$commission,$remaining,$status,$status_text,$obalance,$filled=0,$ouid=null,$tuid=null,$buyer=null){
        $trade = new MarketPlace;
        $trade->uid = $uid;
        $trade->trade_type = $type;
        $trade->ouid = $ouid;
        $trade->tuid = $tuid;
        $trade->buyer = $buyer;
        $trade->order_id = $orderId;
        $trade->pair = $pairID;
        $trade->order_type = 1;
        $trade->price = $price;
        $trade->volume = $volume;
        $trade->value = $total;
        $trade->fees = $fee;
        $trade->commission = $commission;
        $trade->remaining = $remaining;
        $trade->status = $status;
        $trade->status_text = $status_text;
        $trade->post_ty = 'web';
        $trade->balance = $obalance;
        $trade->is_type = 0;
        $trade->filled= $filled;
        $trade->created_at = date('Y-m-d H:i:s',time());
        $trade->save();
        return $trade->id;
    }
    public function user()
    {
      return $this->belongsTo('App\User', 'uid','id');
    }
    public function tradeuser()
    {
      return $this->belongsTo('App\User', 'ouid','id');
    }
    public function pairDetails()
    {
      return $this->belongsTo('App\Models\Tradepair', 'pair','id');
    }
}
