@forelse($buytrades as $buytrade)
@php if($cointwo == 'EUR') { 
    $symbol = '€';
  } else{ 
    $symbol = ''; 
  } @endphp
  <tr
    class=""
    id="trade_id_265729864"
    data-trade-id="{{ $buytrade->id }}"
    data-order-id="{{ $buytrade->order_id }}"
    data-critical-price-formatted="27,700.00"
    data-critical-price="{{ $buytrade->price }}"
    data-trade-type="offer"
    data-amount="{{ $buytrade->remaining }}"
    data-min-amount="0.05"
    data-uid="0yybQZoNoQ8nfFW8rrI."
  >
    <td>{{ $buytrade->remaining }}</td>
    <td>{{ $symbol.''.$buytrade->price }}</td>
    <td>{{ $symbol.''.ncMul($buytrade->price,$buytrade->remaining) }}</td>
  
    <td>
      <a
        class="bc-sbl"
        href="{{ url('p2psell/'.Crypt::encrypt($buytrade->id)) }}"
        >Sell</a
      >
    </td>
  </tr>
  @empty
  <tr>
    <td colspan="4">
       <div class="no_result_display text-center ">
                    <div class="bc-color-red-light">
                        Currently, there is no suitable sales offer for your purchase request.                    </div>
                    <p>
                        You can create a purchase request now, which will be presented to all potential sellers.                    </p>
                        <div class="text-center">
                        <input type="button" id="sellcreate" class="btn btn-block sitebtn green-btn" value="create purchase request" /> </div>
    </div>
    </td>
  </tr>
  @endforelse
   <script type="text/javascript">
   $("#sellcreate").click(function(){
  
  $.ajax({
    type: "POST",
    url: '{{ route("sellMarketCreate") }}', // This is what I have updated
    data: $("#trade_order_form").serialize(),
    }).done(function( request ) {


      if(request.status == 'fail')
      {
        $('#selllimitmsg').html(request.msg);
      }
      else
      {
        $('#selllimitmsg').html(request.msg);
      }

});
    });
  </script>