<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/*Route::get('/', function () {
    return view('welcome');
});*/




Route::get('/security', function () {
    return view('security');
});

Route::get('/termscondition', function () {
    return view('termscondition');
});

Route::get('/amlpolicy', function () {
    return view('amlpolicy');
});

Route::get('/riskdisclosure', function () {
    return view('riskdisclosure');
});

Route::get('/', 'HomeController@landing');
Route::get('/page/{key}','HomeController@show');

Auth::routes();

Route::post('form_referral', 'HomeController@form_referral');
//Route::get('p2p/{pair}', 'HomeController@p2ptrade');

Route::get('/reconfirm_account/{email}', 'Auth\LoginController@reconfirm_account')->name('reconfirm_account');
Route::get('logout', '\App\Http\Controllers\Auth\LoginController@logout');
Route::get('/verifyEmail', 'Auth\RegisterController@verifyEmail')->name('verifyEmail');
Route::get('/verify/{email}', 'EmailVerifyController@sendEmailDone')->name('sendEmailDone');
Route::get('/res/{referral_code}', 'Auth\RegisterController@res')->name('res');
Route::get('/registersuccess', 'EmailVerifyController@registerSuccess')->name('registersuccess');

Route::get('2faverification/diableTwoFactor', 'TwofaController@diableTwoFactor')->name('diableTwoFactor');
Route::get('2faverification-access', 'TwofaController@viewOtppage')->name('twofaotp');
Route::get('resend-otp', 'TwofaController@reSendEmail')->name('resendotp');
Route::post('2faverification-validate', 'TwofaController@validateOTP')->name('verifyotp');
//google 2FA 
Route::post('2faverification/google2faverify', 'TwofaController@verifyGoogleTwoFactor')->name('google2faverify');
Route::get('2faverification/googe2faenable', 'TwofactorController@enableGoogleTwoFactor')->name('googe2faenable');
Route::get('2faverification/googe2faotp', 'TwofactorController@enableGoogleTwoFactorotp')->name('googe2faotp');
Route::post('2faverification/googe2faverifyotp', 'TwofactorController@verifyGoogleTwoFactorotp')->name('googe2faverifyotp');

// Email 2FA
Route::get('2faverification/email2faenable', 'TwofactorController@enableEmailTwoFactor')->name('email2faenable');
Route::get('2faverification/email2fadisable', 'TwofactorController@disableEmailTwoFactor')->name('email2fadisable');
Route::post('2faverification/emailotpverify', 'TwofaController@enableEmailOTP')->name('emailotpverify');
//KYC
Route::get('kyc', 'KycController@index')->name('kyc');
Route::get('quickverify-kyc', 'KycController@hypervergeKyc')->name('hypervergekyc');
Route::post('uploadkyc', 'KycController@uploadkyc')->name('uploadkyc');
//Bank
Route::get('/bank','UserpanelController@bankview')->name('bank');
Route::get('/upi','UserpanelController@upi');
Route::post('/upi-add','UserpanelController@upiadd');
Route::get('/upi-list','UserpanelController@upilist');
Route::get('/bank-add','UserpanelController@addbankdetail');
Route::post('/bank-Add','UserpanelController@addbank');
Route::get('/delete-upi/{id}','UserpanelController@deleteupi');
Route::get('/delete-bank/{id}','UserpanelController@deletebankdetail');

Route::get('/myprofile', 'UserpanelController@profileView')->name('myprofile');
Route::post('userprofile', 'UserpanelController@persinoaldetais_update')->name('userprofile');
Route::post('updateprofileimg', 'UserpanelController@updateprofileimg')->name('updateprofileimg');
Route::post('updatePassword', 'UserpanelController@updatePassword');
Route::get('userkycdetails', 'UserpanelController@kycdetails')->name('userkycdetails');
Route::post('update-bank-info', 'UserpanelController@updateBankDetails')->name('updatebank');
Route::post('update-paypal-info', 'UserpanelController@updatePaypalDetails')->name('updatepaypal');
Route::get('/referral-info', 'UserpanelController@userDownlineList')->name('referralInfo');

Route::get('/home', 'SecurityController@dashboard')->name('home');
Route::get('/support', 'SupportController@supportView')->name('support');
Route::get('/support-ticket/{ticket_id}', 'SupportController@supportView');
Route::post('submitNewTicket', 'SupportController@submitNewTicket')->name('submitNewTicket');
Route::get('viewTicket/{id}', 'SupportController@viewTicket')->name('viewTicket');
Route::post('sendMessage', 'SupportController@sendMessage')->name('sendMessage');
Route::post('ticket-search','SupportController@searchTicket')->name('ticket-search');
//Trade
Route::get('/trade', 'TradeController@index')->name('trade');
Route::get('trades/{pair}','TradeController@index');
Route::post('/trade/buylimit', 'TradeLimitController@buylimit')->name('buylimit');
Route::post('/trade/selllimit', 'TradeLimitController@selllimit')->name('selllimit');
Route::post('/trade/buymarket', 'TradeMarketController@buymarket')->name('buymarket');
Route::post('/trade/sellmarket', 'TradeMarketController@sellmarket')->name('sellmarket');
Route::get('/cancelorder/{id}', 'TradeController@cancelTrade')->name('cancelorder');
Route::get('/market', 'TradeController@marketView')->name('market');
Route::get('/openorders','TradeController@Update_Openorder');
Route::get('/orderhistory','TradeController@Update_Orderhistory');
Route::get('/tradehistoryajax/{id}','TradeController@Update_tradehistory');

Route::get('/market-place', 'P2PMarketplaceController@index')->name('marketplace');
Route::get('/marketplace/{pair}', 'P2PMarketplaceController@index');
Route::get('/p2p-matchorder/{id}','P2PMarketplaceController@p2pMatch');
Route::post('/filterselltrade', 'P2PMarketplaceController@filterSellTrade')->name('filterSellTrade');

Route::post('/filterbuytrade', 'P2PMarketplaceController@filterBuyTrade')->name('filterBuyTrade');
Route::post('/create-p2p-buymarket', 'P2PMarketplaceController@buyMarketCreate')->name('buyMarketCreate');
Route::post('/create-p2p-sellmarket', 'P2PMarketplaceController@sellMarketCreate')->name('sellMarketCreate');
Route::get('/p2psell/{id}', 'P2PMarketplaceController@p2pSell')->name('mysell');
Route::get('/p2pbuy/{id}', 'P2PMarketplaceController@p2pBuy')->name('mybuy');
Route::get('/p2pbuyerinfo/{id}', 'P2PMarketplaceController@p2pBuyEdit')->name('mybuyview');
Route::get('/p2psellerinfo/{id}', 'P2PMarketplaceController@p2pSellEdit')->name('mysellview');
Route::post('/p2pbuyform-submit', 'P2PMarketplaceController@p2pBuyupload')->name('ppbuysubmit');
Route::post('/p2psellform-submit', 'P2PMarketplaceController@p2pSellupload')->name('ppsellsubmit');
Route::post('/p2pbuyerform-update', 'P2PMarketplaceController@buyerUpdate')->name('ppbuyupdate');
Route::post('/p2psellerform-update', 'P2PMarketplaceController@sellerUpdate')->name('ppsellupdate');

Route::get('/p2pmarkethistory', 'P2PMarketplaceController@trade')->name('p2phistory');
Route::get('/p2pmarketsuccess', 'P2PMarketplaceController@deposits')->name('success');
Route::get('/p2pmarketunsuccess', 'P2PMarketplaceController@withdraw')->name('failure');

Route::get('/latest-matchhistroy/{id}', 'P2PMarketplaceController@ajaxMatchhistroy');
Route::post('/update-xid', 'P2PMarketplaceController@updateXID')->name('updateXID');
Route::post('/cancel-p2ptrade', 'P2PMarketplaceController@p2pTradeCancel')->name('p2pcancel');
Route::post('/upload-proofslip', 'P2PMarketplaceController@proofUpload')->name('p2pproofUpload');
Route::get('/p2p-paymenttype/{orderid}/{type}', 'P2PMarketplaceController@paymenttypeUpdate');
Route::post('/p2p-paymentreceived', 'P2PMarketplaceController@completeP2p')->name('p2pcompelte');
Route::get('/latest-marketdepth/{id}/{type}','P2PMarketplaceController@ajaxMarketdepth');

//chart
Route::get('/config', 'TradingViewChartServerController@config');
Route::get('/time', 'TradingViewChartServerController@time');
Route::get('/symbols', 'TradingViewChartServerController@symbols');
Route::get('/symbol_info', 'TradingViewChartServerController@symbol_info');
Route::get('/history', 'TradingViewChartServerController@history');
Route::get('/marks', 'TradingViewChartServerController@marks');
Route::get('/timescale_marks', 'TradingViewChartServerController@timescale_marks');
Route::get('/tradechart', 'TradeChartController@getTradeChartDetails');
Route::get('marketdepthchart/{pair}', 'TradeChartController@marketdepthchart');
Route::get('tradetest', 'TradingViewChartServerController@vvchart');
Route::get('exchangemarketdepthchart/{id}', 'HomeController@exchangemarketdepthchart');
Route::get('marketdepthchart/{pair}','TradeChartController@marketdepthchart');
//Wallet
Route::get('/wallet', 'WalletController@index')->name('wallet');
Route::get('deposit/{coin}', 'WalletController@deposit');
Route::get('/withdraw/{coin}', 'WalletController@withdraw')->name('withdraw');
Route::get('/withdrawconform', 'WalletController@withdraw_otp')->name('withdrawotp');
Route::post('/validateotp', 'WalletController@withdrawstore')->name('validateotp');

Route::post('/verifywithdraw', 'WalletController@validatecryptoWithdraw')->name('validatecryptoWithdraw');
Route::get('/approvewithdraw/{email}/{toaddress}', 'WalletController@approvewithdraw')->name('approvewithdraw');
//Histroy
Route::get('/histroy', 'HistroyController@index')->name('histroy');
Route::get('/deposit-histroy', 'HistroyController@deposit')->name('deposithistroy');
Route::get('/withdraw-histroy', 'HistroyController@withdraw')->name('withdrawhistroy');
Route::get('/trade-histroy', 'HistroyController@trade')->name('tradehistroy');
Route::post('/trade-search','HistroyController@tradeSearch');

//Test
Route::get('/importuser', 'HomeController@importUser');




Route::get('setlocale/{locale}', function ($locale) {
	if (in_array($locale, \Config::get('app.locales'))) {
		Session::put('locale', $locale);
	}
	return redirect()->back();
});
Route::get('setmode/{mode}', function ($mode) {
    Session::put('mode', $mode);
 
  return redirect()->back();
});