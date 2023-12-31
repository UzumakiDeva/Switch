<html>
<head>
<style>
html, body {
  height: 100%;
  margin: 0;
}

.tradingview-widget-container {
  height: 100%;
  
}
</style>
</head>
<body>
<div class="tradingview-widget-container">
	<div id="tradingview_49396"></div>
</div>
<script type="text/javascript" src="{{url('js/charting-library/charting_library.min.js')}}"></script>
<script type="text/javascript" src="{{url('js/datafeeds/udf/dist/polyfills.js')}}"></script>
<script type="text/javascript" src="{{ url('js/datafeeds/udf/dist/bundle.js') }}"></script>
<script type="text/javascript">

	function getParameterByName(name) {
		name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
		var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
		results = regex.exec(location.search);
		return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
	}

	TradingView.onready(function()
	{
		var widget = window.tvWidget = new TradingView.widget({
		// debug: true, // uncomment this line to see Library errors and warnings in the console
		autosize : true,
		symbol: '{{ $selectPair->coinone.'/'.$selectPair->cointwo }}',
		interval: 'D',
		container_id: "tradingview_49396",
		theme: "Dark",
		style: "1",
		enable_publishing: false,
		hide_top_toolbar: false,
		hide_legend: false,
		save_image: false,

		datafeed: new Datafeeds.UDFCompatibleDatafeed("{{ url('/') }}"),
		library_path: "{{ url('/js/charting-library') }}/",
		locale: getParameterByName('lang') || "en",
		//  Regression Trend-related functionality is not implemented yet, so it's hidden for a while
		drawings_access: { type: 'black', tools: [ { name: "Regression Trend" } ] },
		disabled_features: ["use_localstorage_for_settings"],
		enabled_features: ["study_templates"],
		charts_storage_url: 'http://saveload.tradingview.com',
		charts_storage_api_version: "1.1",
		client_id: 'tradingview.com',
		user_id: 'public_user_id',
		@if(Session::get('mode') =='nightmode')
		overrides: {
			"paneProperties.background": "#191919",
			"paneProperties.vertGridProperties.color": "#ccc",
			"paneProperties.horzGridProperties.color": "#ccc",
			"symbolWatermarkProperties.transparency": 90,
			"scalesProperties.textColor": "#fff",
		}
		@else

		overrides: {
			"paneProperties.background": "#000",
			"paneProperties.vertGridProperties.color": "#000",
			"paneProperties.horzGridProperties.color": "#1c1f24",
			"symbolWatermarkProperties.transparency": 90,
			"scalesProperties.textColor": "#fff",
		}
		@endif

		});
	});

</script>
</body>
</html>