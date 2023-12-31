<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\User;
use App\Models\AffilateCommission;
use App\Models\Wallet;
use App\Models\Adminwallet;

class AffliateTransaction extends Model
{
    protected $table = 'affliate_transaction'; 

     public static function affliate_transaction($userid,$coin,$amount,$type,$price,$quantity){
    $users 		 = User::where('id',$userid)->first(); 
    $refcode	 = $users->parent_id ;  // myself code  
    $commissions = AffilateCommission::get(); 
    $creditamount = $amount;
    $totalamount  = 0;
    $calculate  = 0;
    //$type  = '';


    if($refcode != ''){
      if(count($commissions) > 0){ 
         foreach($commissions as $commission) { 

          $coin = $commission->coin;
              
            $referuser = User::where('referral_id',$refcode)->first();

             //dd($type);
            if($referuser){

                if($type == 'deposit')
      					{
      						$dbcommission = $commission->deposit ;
      					}
      					elseif($type == 'trade' || $type == 'Buy' || $type == 'Sell') 
      					{
      						$dbcommission = $commission->trade ;
      					}
      					else
      					{
      						return 'Invalid type';

      					}


              $calculate  = bcdiv(sprintf('%.10f',$dbcommission),100,8);
              $commission_affilate = bcmul(sprintf('%.10f',$amount) ,sprintf('%.10f',$calculate),8);
              $adminfee = $commission_affilate;
              if($adminfee > 0)
              {
                    $uid = $referuser->id;  
                    $remark = "User ".$coin." affiliate request";
                    
                    $insertid = self::CreateTransaction($uid,$userid,$coin,$type,$adminfee,$price,$quantity);
                    $creditamount = ncSub($creditamount,$adminfee);
                    $totalamount  = ncAdd($totalamount,$adminfee);

                    Wallet::creditAmount($uid, $coin, $adminfee,8,'affiliate',$remark,$insertid); 
              }
              else
              {
                break;
              }
              
        
          }else { 
            break;
          } 
          $refcode = $referuser->parent_id;  
        }            
      }
      if($amount  > 0){
        $remainfee = ncSub($amount,$totalamount);
        if($remainfee > 0){
          Adminwallet::admincreditAmount($coin, $remainfee,$calculate,$type );
        }

      }    
    }
    else{

        if($amount > 0)
        {

          Adminwallet::admincreditAmount($coin, $amount,$calculate,$type);

        }
    } 
    return 'done';
  }



  public static function CreateTransaction($uid,$from_id,$coin,$reason,$commission_affilate,$price,$quantity){

   $affliate_transaction = new  AffliateTransaction();
   $affliate_transaction->uid  = $uid;
   $affliate_transaction->from_id  = $from_id;
   $affliate_transaction->coin  = $coin;
   $affliate_transaction->reason  = $reason;
   $affliate_transaction->quantity  = $quantity;
   $affliate_transaction->price  = $price;
   $affliate_transaction->commission  = $commission_affilate;
   $affliate_transaction->created_at = date('Y-m-d H:i:s',time());
   $affliate_transaction->updated_at = date('Y-m-d H:i:s',time());
   $affliate_transaction->save();

   return $affliate_transaction->id;
 }

  public function user() {
        return $this->belongsTo('App\User', 'from_id', 'id');
    }


}
