@forelse($selltrades as $selltrade)
@php if($cointwo == 'EUR') { 
                            $symbol = '€';
                          } else{ 
                            $symbol = ''; 
                          } @endphp
                            <tr
                              class=""
                              id="trade_id_265729864"
                              data-trade-id="{{ $selltrade->id }}"
                              data-order-id="{{ $selltrade->order_id }}"
                              data-critical-price-formatted="27,700.00"
                              data-critical-price="{{ $selltrade->price }}"
                              data-trade-type="offer"
                              data-amount="{{ $selltrade->remaining }}"
                              data-min-amount="0.05"
                              data-uid="0yybQZoNoQ8nfFW8rrI."
                            >
                              <td>{{ $selltrade->remaining }}</td>
                              <td>{{ $symbol.''.$selltrade->price }}</td>
                              <td>{{ $symbol.''.ncMul($selltrade->price,$selltrade->remaining) }}</td>
                            
                              <td>
                                <a
                                  class="bc-sbl"
                                  href="{{ url('p2pbuy/'.Crypt::encrypt($selltrade->id)) }}"
                                  >BUY</a
                                >
                              </td>
                            </tr>
                            @empty
  <tr>

    <td colspan="4">
      <div class="no_result_display text-center ">
                    <div class="bc-color-red-light">
                        Currently, there is no suitable purchase request for your sales offer.                    </div>
                    <p>
                        You can create a sales offer now, which will be presented to all potential buyers.                    </p>
                        <input type="button" id="buycreate" class="btn btn-block sitebtn green-btn" value="create a sales offer" /> </div>
    </div>
  </td>
  </tr>
  @endforelse
  <script type="text/javascript">
   $("#buycreate").click(function(){
  
  $.ajax({
    type: "POST",
    url: '{{ route("buyMarketCreate") }}', // This is what I have updated
    data: $("#trade_offer_form").serialize(),
    }).done(function( request ) {


      if(request.status == 'fail')
      {
        $('#buylimitmsg').html(request.msg);
      }
      else
      {
        $('#buylimitmsg').html(request.msg);
      }

});
    });
  </script>