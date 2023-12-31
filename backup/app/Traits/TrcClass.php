<?php
namespace App\Traits;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Mail;

use App\Traits\Trc;
use App\Traits\Tron;
use App\UserTokenAddress;
use App\TokenTransaction;
use App\FeeTokenWallet;
use App\Mail\AcceptDepositEmail;
use App\User;

trait TrcClass 
{
	use Trc,Tron;
	public function createTrcAddress($user)
    {
        $is_address = UserTokenAddress::where('user_id',$user)->first();
        if(!$is_address){
        $eth = $this->trc_user_address_create();
        $address = $eth['address'];
        $publickey = Crypt::encrypt($eth['hexAddress']);
        $privatekey = Crypt::encrypt($eth['privateKey']);

        if($eth['hexAddress'] != NULL && $eth['hexAddress'] != '' && $eth['privateKey'] != NULL && $eth['privateKey'] != '')
        {
            $ethaddress = new UserTokenAddress();
            $ethaddress->user_id = $user;
            $ethaddress->mugavari = $address;
            $ethaddress->narcanru = $publickey.','.$privatekey;
            $ethaddress->balance = 0.00000000;
            $ethaddress->trx_balance = 0.00000000;
            $ethaddress->status = 0;
            $ethaddress->active = 1;
            $ethaddress->save();
        }
        }
        return true;
    }
    public function createFeeTrcAddress($user)
    {
        $is_address = FeeTokenWallet::where('user_id',$user)->first();
        if(!$is_address){
            $eth = $this->trc_user_address_create();
            $address = $eth['address'];
            $publickey = Crypt::encrypt($eth['hexAddress']);
            $privatekey = Crypt::encrypt($eth['privateKey']);

            if($eth['hexAddress'] != NULL && $eth['hexAddress'] != '' && $eth['privateKey'] != NULL && $eth['privateKey'] != '')
            {
                $ethaddress = new FeeTokenWallet();
                $ethaddress->user_id = $user;
                $ethaddress->mugavari = $address;
                $ethaddress->narcanru = $publickey.','.$privatekey;
                $ethaddress->balance = 0.00000000;
                $ethaddress->trx_balance = 0.00000000;
                $ethaddress->status = 0;
                $ethaddress->active = 1;
                $ethaddress->save();
            }
        }
        return true;
    }
	public function UpdateTransaction($uid,$remark='Deposit'){
        $is_address = UserTokenAddress::where('user_id',$uid)->first();
		if($is_address){
        $address = $is_address->mugavari;
		$balance = $this->tr10trans($address);        
        
       
        if(isset($balance['data']))
        {
            $count = count($balance['data']);
            if($count > 0)
            {
                $is_hex = $this->getHexFormat($address);
                $result_data = $balance['data'];
				
                for($i = 0; $i < $count; $i++)
                {

                    $data = $result_data[$i];
                    $tx_hash = $data['txID'];
					
                    $get_value = $data['raw_data']['contract'][0]['parameter']['value'];
                    if(isset($get_value['asset_name'])){
                        $assetid = $get_value['asset_name'];
                    }else{
                        $assetid = "";
                    }
                    //convert value
                    $amount = $get_value['amount'] / 1000000;
					
                    $type = 'send';
					$remark='Withdraw';
                    if($is_hex->hex_address == strtolower($get_value['to_address']))
                    {
                        $type    = 'received';
						$remark = 'Deposit';
						
                    }
					if($assetid == 1003414){
                        $from_addr = $get_value['owner_address'];
                        $is_from = $this->getHextoAddressFormat($get_value['owner_address']);
                        if(isset($is_from->hex_address) && $is_from->hex_address != '')
                        {
                            $from_addr = $is_from->hex_address;
                        }
                        $address = $get_value['to_address'];
                        $is_to = $this->getHextoAddressFormat($get_value['to_address']);
                        if(isset($is_to->hex_address) && $is_to->hex_address != '')
                        {
                            $address = $is_to->hex_address;
                        }

						$is_txn = TokenTransaction::where(['txid' => $tx_hash,'uid' => $uid])->first();
						if(!$is_txn)
						{
							$Transaction = new TokenTransaction;
							$Transaction->uid           = $uid;
							$Transaction->currency      = "NAS";
							$Transaction->txtype        = $type;
							$Transaction->txid          = $tx_hash;
							$Transaction->from_addr     = $from_addr;
							$Transaction->to_addr       = $address;
							$Transaction->amount        = $amount;
							$Transaction->com_amount    = 0;
							$Transaction->status        = 1;
							$Transaction->level         = 0;
							$Transaction->nirvaki_nilai = 0;
							$Transaction->remarks        = $remark;
							$Transaction->save();
							$is_balance = UserTokenAddress::where('user_id',$uid)->first();
							$received = $is_balance->received;
							$send = $is_balance->send;
							if($type == 'received'){                            
								$cbalance = ncAdd($is_balance->balance,$amount);
								$received = ncAdd($received,$amount);
								$uncbalance = ncSub($is_balance->unconform_balance,$amount);
								if($uncbalance <= 0){
									$uncbalance = 0;
								}
								
							}else{
								$cbalance = ncSub($is_balance->balance,$amount);
								$send = ncAdd($send,$amount);
								$uncbalance = ncSub($is_balance->unconform_balance,$amount);
								if($uncbalance <= 0){
									$uncbalance = 0;
								}
							}
							$is_balance->received = $received;
							$is_balance->send = $send;
							$is_balance->balance = $cbalance;
							$is_balance->unconform_balance = $uncbalance;
							$is_balance->updated_at = date('Y-m-d H:i:s',time());
							$is_balance->save();
							
							$credential = explode(',',$is_address->narcanru);
							$narcanru = Crypt::decrypt($credential[0]);
							$bdata = $this->getTrxBalance($narcanru);
							$trx_balance = 0;
							if(isset($bdata['balance'])){
								$trx_balance = $this->convertTrx($bdata['balance']);
							}
							
							$is_address->trx_balance = $trx_balance;
							$is_address->save();
							$user = User::where('id',$uid)->first();
							$details = array(
									'status'     => 'Accept',
									'coin'       => "NAOS",
									'amount'     => $amount,
									'user'       => $user->name 
							); 
							
							//Mail::to($user->email)->send(new AcceptDepositEmail($details));
					   }else{
							//$is_txn->to_addr       = $address;
							//$is_txn->save();
					   }
				   }
               }
           }
       }
	   }else{
			$this->createTrcAddress($uid);
	   }
    }
	public function tr10trans($address){
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, "https://api.trongrid.io/v1/accounts/".$address."/transactions");
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		$headers = array();
		$headers[] = "Content-Type : application/json";
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		$result = curl_exec($ch);
		if (curl_errno($ch)) {
			echo 'Error:' . curl_error($ch);
		}
		curl_close($ch);
		return $balance= json_decode($result, true);
	}

    public function UpdateTransactiontrc20($uid,$remark='Deposit'){
        $is_address = UserTokenAddress::where('user_id',$uid)->first();
		if($is_address){
        $address = $is_address->mugavari;        
        $balance = $this->getTrcTransaction($address);
        if(isset($balance['data']))
        {
            $count = count($balance['data']);
            if($count > 0)
            {
                $result_data = $balance['data'];
				
                for($i = 0; $i < $count; $i++)
                {
                    $data = $result_data[$i];
                    $tx_hash = $data['transaction_id'];
                    $token_info = $data['token_info']['symbol'];
                    $from_addr = $data['from'];

                    //convert value
                    $get_value = $this->weitotrc($data['value'],$data['token_info']['decimals']);
					
                    $type = 'send';
                    if($address == $data['to'])
                    {
                        $type = 'received';
                    }
					
					if($token_info == 'NAS'){
						$is_txn = TokenTransaction::where('txid', $tx_hash)->first();
						if(!$is_txn)
						{
							$Transaction = new TokenTransaction;
							$Transaction->uid           = $uid;
							$Transaction->currency      = $token_info;
							$Transaction->txtype        = $type;
							$Transaction->txid          = $tx_hash;
							$Transaction->from_addr     = $from_addr;
							$Transaction->to_addr       = $address;
							$Transaction->amount        = $get_value;
							$Transaction->com_amount    = 0;
							$Transaction->status        = 1;
							$Transaction->level         = 0;
							$Transaction->nirvaki_nilai = 0;
							$Transaction->remarks        = $remark;
							$Transaction->save();
							if($type == 'received'){                            
								$cbalance = ncAdd($is_address->balance,$get_value);
								$uncbalance = ncSub($is_address->unconform_balance,$get_value);
								if($uncbalance <= 0){
									$uncbalance = 0;
								}
								
							}else{
								$cbalance = ncSub($is_address->balance,$get_value);
								$uncbalance = ncSub($is_address->unconform_balance,$get_value);
								if($uncbalance <= 0){
									$uncbalance = 0;
								}
							}
							$is_address->balance = $cbalance;
							$is_address->unconform_balance = $uncbalance;
							$is_address->updated_at = date('Y-m-d H:i:s',time());
							$is_address->save();
							
							$credential = explode(',',$is_address->narcanru);
							$narcanru = Crypt::decrypt($credential[0]);
							$bdata = $this->getTrxBalance($narcanru);
							$trx_balance = 0;
							if(isset($bdata['balance'])){
								$trx_balance = $this->convertTrx($bdata['balance']);
							}
							
							$is_address->trx_balance = $trx_balance;
							$is_address->save();
					   }
				   }
               }
           }
       }
	   }else{
			$this->createTrcAddress($uid);
	   }
    }
    public function weitotrc($amount,$tokenDecimal=null){
        if($tokenDecimal){
            if($tokenDecimal > 0){
               $tokenDecimal = 1 + $tokenDecimal;
                $number = 1;
                $number = str_pad($number, $tokenDecimal, '0', STR_PAD_RIGHT);  
            }else{
                $number = 1;
            }         
            return $amount / $number;
        }else{
            return $amount / 1;
        }
    }
    public function weitrc($amount,$tokenDecimal=null){
        if($tokenDecimal){
            if($tokenDecimal > 0){
               $tokenDecimal = 1 + $tokenDecimal;
                $number = 1;
                $number = str_pad($number, $tokenDecimal, '0', STR_PAD_RIGHT);  
            }else{
                $number = 1;
            }         
            return $amount * $number;
        }else{
            return $amount * 1;
        }
    }
    public function ReciveTRC20UserToken($amount,$uid){
        $is_address = UserTokenAddress::where('user_id',$uid)->first();
        $to_address = $is_address->mugavari;
        $admin = FeeTokenWallet::first();
        $credential = explode(',',$admin->narcanru);
        $narcanru = Crypt::decrypt($credential[1]);
        $total_send_amount = $this->weitrc($amount,6);
        $contract = "TTkdwFhrH2q5LrZ5Nv5HVyd5zh9mrUFMQi";
        $fee_limit = 100000;
        $send = $this->sendTrcTransaction($to_address, $narcanru, $total_send_amount, $contract, $fee_limit);
        return $send->txid;
    }
    public function SendTRC20UserToken($amount,$uid,$to_address){
        $is_address = UserTokenAddress::where('user_id',$uid)->first();        
        $credential = explode(',',$is_address->narcanru);
        $narcanru = Crypt::decrypt($credential[1]);
        $total_send_amount = $this->weitrc($amount,6);
        $contract = "TTkdwFhrH2q5LrZ5Nv5HVyd5zh9mrUFMQi";
        $fee_limit = 100000;
        $send = $this->sendTrcTransaction($to_address, $narcanru, $total_send_amount, $contract, $fee_limit);
        return $send->txid;
    }

    public function UserTrcFeeMoveAmount($uid){
        $get_admin_address = FeeTokenWallet::first();
        $from_address = $get_admin_address->mugavari;
        $credential = explode(',',$get_admin_address->narcanru);
        $narcanru = Crypt::decrypt($credential[1]);
        $is_address = UserTokenAddress::where('user_id',$uid)->first();
        $to_address = $is_address->mugavari;		
        $amount = 1;
        $total_send_amount = $amount * 1000000;
        if($to_address !='' && $to_address !=NULL)
        {
            $is_hex = $this->getHexFormat($to_address);
			$toaddress = $is_hex->hex_address;
            $send = $this->sendTrxWebTransaction($toaddress, $narcanru, $total_send_amount);
            if(isset($send->txid->transaction->txID) && $send->txid->transaction->txID!='')
            {
               return $send->txid->transaction->txID;
            }else{
                return false;
            }
        }
    }

    public function UserTrc10ReceiveAmount($uid,$amount){
        $get_admin_address = FeeTokenWallet::first();
        $from_address = $get_admin_address->mugavari;
        $credential = explode(',',$get_admin_address->narcanru);
        $narcanru = Crypt::decrypt($credential[1]);
        $is_address = UserTokenAddress::where('user_id',$uid)->first();
        $to_address = $is_address->mugavari;		
        //$amount = 1;
        $total_send_amount = $amount * 1000000;
        if($to_address !='' && $to_address !=NULL)
        {
            $is_hex = $this->getHexFormat($to_address);
			$toaddress = $is_hex->hex_address;
            $send = $this->sendTrc10WebTransaction($toaddress, $narcanru, $total_send_amount,'1003414');
            if(isset($send->txid->transaction->txID) && $send->txid->transaction->txID!='')
            {
               return $send->txid->transaction->txID;
            }else{
                return false;
            }
        }
    }

    public function UserTrc10sendAmount($amount,$uid,$to_address){
        $is_address = UserTokenAddress::where('user_id',$uid)->first();        
        $credential = explode(',',$is_address->narcanru);
        $narcanru = Crypt::decrypt($credential[1]);		
        //$amount = 1;
        $total_send_amount = $amount * 1000000;
        if($to_address !='' && $to_address !=NULL)
        {
            $is_hex = $this->getHexFormat($to_address);
			$toaddress = $is_hex->hex_address;
            $send = $this->sendTrc10WebTransaction($toaddress, $narcanru, $total_send_amount,'1003414');
            if(isset($send->txid->txid) && $send->txid->txid!='')
            {
               return $send->txid->transaction->txID;
            }else{
                return false;
            }
        }
    }

    public function UserTrxTransaction()
    {
        $user_eth_address = UserTokenAddress::on('mysql2')->where([['active', '=', '1']])->get();
        if($user_eth_address && $user_eth_address->count() > 0)
        {
            foreach($user_eth_address as $user_datasss)
            {
                $eth_address = DogeMugavari::on('mysql2')->where('uid', $user_datasss->id)->first();
                if(count($eth_address) > 0)
                {
                    $address = $eth_address->mugavari;
                    //get trx hex format
                    $is_hex = $this->getHexFormat($address);
                    $user_id = $eth_address->uid;
                    if($address != '' && $is_hex != '')
                    {
                        $balance = $this->getTrxTransaction($address);
                        if(isset($balance['data']))
                        {
                            $count = count($balance['data']);
                            if($count > 0)
                            {
                                $result_data = $balance['data'];
                                for($i = 0; $i < $count; $i++)
                                {
                                    $data = $result_data[$i];
                                    $tx_hash = $data['txID'];
                                    $get_value = $data['raw_data']['contract'][0]['parameter']['value'];
                                    $type = 'send';
                                    if(($is_hex == $get_value['to_address']) && !isset($get_value['asset_name']))
                                    {
                                        $type = 'received';
                                    }

                                    $is_txn = TrxTransaction::on('mysql2')->where('txid', $tx_hash)->first();
                                    if(!$is_txn && $type == 'received')
                                    {
                                        $from_addr = $get_value['owner_address'];

                                        $is_from = $this->getHextoAddressFormat($get_value['owner_address']);
                                        if(isset($is_from->hex_address) && $is_from->hex_address != '')
                                        {
                                            $from_addr = $is_from->hex_address;
                                        }

                                        $EthTransaction = new TrxTransaction;
                                        $EthTransaction->setConnection('mysql2');
                                        $EthTransaction->uid           = $user_datasss->id;
                                        $EthTransaction->txtype        = $type;
                                        $EthTransaction->txid          = $tx_hash;
                                        $EthTransaction->from_addr     = $from_addr;
                                        $EthTransaction->to_addr       = $address;
                                        $EthTransaction->amount        = $get_value['amount'] / 1000000;
                                        $EthTransaction->save();
                                   }
                               }
                           }
                       }
                   }
               }
           }
       }
    }

    public function UserTrxMoveAmount()
    {
        $minimum_deposit = $deposit = 0;
        $commission = Token::on('mysql2')->where('token', 'TRX')->first();
        if(is_object($commission))
        {
            $minimum_deposit = $commission->deposit_limit;
            $deposit = $commission->deposit_fee;
        }

        $move_amount_data = DogeTransaction::on('mysql2')->select('uid', DB::raw('SUM(amount) as amt'), DB::raw("GROUP_CONCAT(id) AS ids"))->where(['status' => 0])->groupBy('uid')->get(); 

        if($move_amount_data && $move_amount_data->count() > 0)
        {
            foreach($move_amount_data as $move_amount)
            {
                //begin trasnaction
                DB::beginTransaction();

                try
                {
                    $user_id = $move_amount->uid;
                    $get_user_address = $this->getUserAddress('TRX', $user_id);
                    if(count($get_user_address) > 0)
                    {
                        $from_address = $get_user_address->mugavari;
                        $credential = explode(',',$get_user_address->narcanru);
                        $narcanru = Crypt::decrypt($credential[1]);

                        $eth_balance = $move_amount->amt;
                        if($eth_balance > 0)
                        {
                            if($minimum_deposit <= $eth_balance)
                            {
                                $amount = $move_amount->amt;
                                $number = 1000000;
                                $total_send_amount = bcmul(sprintf('%.8f',$amount), sprintf('%.8f',$number), 0);

                                //get admin address
                                $to_address = $this->getAdminAddress('TRX');
                                if($to_address !='' && $to_address !=NULL)
                                {
                                    $send = $this->sendTrxWebTransaction($to_address, $narcanru, $total_send_amount);
                                    if(isset($send->txid->transaction->txID) && $send->txid->transaction->txID!='')
                                    {
                                        $ids = explode(',',$move_amount->ids);
                                        foreach ($ids as $id) {
                                            //update status
                                            $is_data = DogeTransaction::on('mysql2')->where([['id', '=', $id], ['status', '=', 0]])->update(['status' => 3]);
                                        }

                                        $is_confirm = new ConfirmTransaction();
                                        $is_confirm->setConnection('mysql2');
                                        $is_confirm->uid = $user_id;
                                        $is_confirm->refer_id = $move_amount->ids;
                                        $is_confirm->amount = $amount;
                                        $is_confirm->currency = 'TRX';
                                        $is_confirm->trxn_id = $send->txid->transaction->txID;
                                        $is_confirm->ourfee = 0;
                                        $is_confirm->netfee = 0;
                                        $is_confirm->confirm_status = 0;
                                        $is_confirm->save();

                                        //permant trasnaction
                                        DB::commit();
                                    }
                                }
                            }
                        }
                    }
                }
                catch(Exception $e)
                {
                    //rollback
                    DB::rollback();
                }
            }
        }
    }

    public function UserTrcTransaction()
    {
        $user_eth_address = CoinUser::on('mysql2')->where([['login_status', '=', '1']])->get();
        if($user_eth_address && $user_eth_address->count() > 0)
        {
            foreach($user_eth_address as $user_datasss)
            {
                $eth_address = TrcMugavari::on('mysql2')->where('uid', $user_datasss->id)->first();
                if(count($eth_address) > 0)
                {
                    $address = $eth_address->mugavari;
                    //get trx hex format
                    $is_hex = $this->getHexFormat($address);
                    $user_id = $eth_address->uid;
                    if($address != '' && $is_hex != '')
                    {
                        $balance = $this->getTrcTransaction($address);
                        if(isset($balance['data']))
                        {
                            $count = count($balance['data']);
                            if($count > 0)
                            {
                                $result_data = $balance['data'];
                                for($i = 0; $i < $count; $i++)
                                {
                                    $data = $result_data[$i];
                                    $tx_hash = $data['transaction_id'];
                                    $token_info = $data['token_info']['symbol'];
                                    $from_addr = $data['from'];

                                    //convert value
                                    $get_value = $this->convertTrc($data['value']);

                                    $type = 'send';
                                    if($address == $data['to'])
                                    {
                                        $type = 'received';
                                    }

                                    $is_txn = TrcTransaction::on('mysql2')->where('txid', $tx_hash)->first();
                                    if(!$is_txn && $type == 'received' && $token_info == 'USDT')
                                    {
                                        $EthTransaction = new TrcTransaction;
                                        $EthTransaction->setConnection('mysql2');
                                        $EthTransaction->uid           = $user_datasss->id;
                                        $EthTransaction->txtype        = $type;
                                        $EthTransaction->txid          = $tx_hash;
                                        $EthTransaction->from_addr     = $from_addr;
                                        $EthTransaction->to_addr       = $address;
                                        $EthTransaction->amount        = $get_value;
                                        $EthTransaction->save();
                                   }
                               }
                           }
                       }
                   }
               }
           }
       }
    }
}