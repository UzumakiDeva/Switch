  $(window).scroll(function() 
{    
	var scroll = $(window).scrollTop();	 
	if (scroll >= 100) {
		$(".headbg").addClass("darkHeader");
	}	
	else
	{
		$(".headbg").removeClass("darkHeader");
	}
}); 

$("#sellpagescroll").animate({ scrollTop: 20000000 }, "slow");
$(function(){
    $("#sellpagescroll tbody").each(function(elem,index){
      var arr = $.makeArray($("tr",this).detach());
      arr.reverse();
        $(this).append(arr);
    });
});


$('.limitabbg .dropdown-menu a:first-child').click(function() 
{
    $(".limitabbg .dropdown").addClass("ocoactive");
    $(".stopdetails").addClass("none");
    $(".ocodetails").removeClass("none");
    $(".ocotitle").removeClass("none");
    $(".stoptitle").addClass("none");
    $("body").addClass("expandhistoryscroll");
});
$('.limitabbg .dropdown-menu a:last-child').click(function() 
{
    $(".limitabbg .dropdown").addClass("stopactive");
    $(".stopdetails").removeClass("none");
    $(".ocodetails").addClass("none");
    $(".stoptitle").removeClass("none");
    $(".ocotitle").addClass("none");
    $("body").removeClass("expandhistoryscroll");
});

$('.balalnceflexbox>div:first-child .tabbanner li:first-child a').click(function() 
{
    $(".spotorderbox").removeClass("none");
    $(".adsbox").addClass("none");  
});

$('.balalnceflexbox>div:first-child .tabbanner li:last-child a').click(function() 
{
    $(".spotorderbox").addClass("none");
    $(".adsbox").removeClass("none");  
});

$("#nightmode").click(function()
{
    $("#nightmode").addClass("activemode")
    $("#daymode").removeClass("activemode")
    $("body").addClass("nightmode")
});

$("#daymode").click(function()
{
    $("#daymode").addClass("activemode")
    $("#nightmode").removeClass("activemode")
    $("body").removeClass("nightmode")
});

$( document ).ready(function() {
$(function(){
   var current = location.pathname;
   $('.leftsidemenu ul li a').each(function(){
       var $this = $(this);  
       if(current.indexOf($this.attr('href')) !== -1){      
        $(this).closest('a').addClass('active');
       }else{
        $(this).closest('a').removeClass('active');
     }
   })
})
  }); 


$(document).ready(function() {
	function t() {
		$(window).width() < 768 ? $(".table-responsive-stack").each(function(t) {
			$(this).find(".table-responsive-stack-thead").show(), $(this).find("thead").hide()
		}) : $(".table-responsive-stack").each(function(t) {
			$(this).find(".table-responsive-stack-thead").hide(), $(this).find("thead").show()
		})
	}
	$(".table-responsive-stack").each(function(t) {
		var e = $(this).attr("id");
		$(this).find("th").each(function(t) {
			$("#" + e + " td:nth-child(" + (t + 1) + ")").prepend('<span class="table-responsive-stack-thead">' + $(this).text() + " : </span> "), $(".table-responsive-stack-thead").hide()
		})
	}), $(".table-responsive-stack").each(function() {
		var t = $(this).find("th").length,
			e = 100 / t + "%";
		$(this).find("th, td").css("flex-basis", e)
	}), t(), window.onresize = function(e) {
		t()
	}
});

$(".mobilegrid>li:first-child").click(function()
	{
		$(".tradepage").addClass("chartactive");
		$(".tradepage").removeClass("openorderactive");
		$(".tradepage").removeClass("tradeactive");
	});
	$(".mobilegrid>li:nth-child(2)").click(function()
	{
		$(".tradepage").removeClass("chartactive");
		$(".tradepage").addClass("openorderactive");
		$(".tradepage").removeClass("tradeactive");
	});
	$(".mobilegrid>li:nth-child(3)").click(function()
	{
		$(".tradepage").removeClass("chartactive");
		$(".tradepage").removeClass("openorderactive");
		$(".tradepage").addClass("tradeactive");
	});
	$(".clostbuytab a").click(function()
	{
		$(".tradepage").removeClass("buyorderformactive1");
		$(".tradepage").removeClass("sellorderformactive1");
	});
    $(".buyselltab>li:first-child").click(function()
{
	$(".tradepage").addClass("buyorderformactive1");
	$(".tradepage").removeClass("sellorderformactive1");
});
$(".buyselltab>li:nth-child(2)").click(function()
{
	$(".tradepage").addClass("sellorderformactive1");
	$(".tradepage").removeClass("buyorderformactive1");
});
$(".buyboxorder tr>td:first-child").click(function()
{
	$(".tradepage").addClass("buyorderformactive1");
	$(".tradepage").removeClass("sellorderformactive1");
});
$(".sellboxorder tr>td:first-child").click(function()
{
	$(".tradepage").addClass("sellorderformactive1");
	$(".tradepage").removeClass("buyorderformactive1");
});

$(document).ready(function () {
    $('#sidebarCollapse').on('click', function () {
        $('.leftsidemenu').toggleClass('active');
        $('body').toggleClass('pagewrapperbox');
        $(".headbg .collapse").removeClass("show");
    });
    $('#closeCollapse').on('click', function () {
        $('.leftsidemenu').removeClass('active');
        $('body').removeClass('pagewrapperbox');
    });
});

var elem = document.documentElement;
function openFullscreen() {
  if (elem.requestFullscreen) {
    elem.requestFullscreen();
    $(".openicon").addClass("openscreen");
    $(".closeicon").removeClass("closescreen");
  } else if (elem.webkitRequestFullscreen) { /* Safari */
    elem.webkitRequestFullscreen();
    $(".openicon").addClass("openscreen");
    $(".closeicon").removeClass("closescreen");
  } else if (elem.msRequestFullscreen) { /* IE11 */
    elem.msRequestFullscreen();
    $(".openicon").addClass("openscreen");
    $(".closeicon").removeClass("closescreen");
  }
}

function closeFullscreen() {

  if (document.exitFullscreen) {
    document.exitFullscreen();
    $(".closeicon").addClass("closescreen");
    $(".openicon").removeClass("openscreen");
  } else if (document.webkitExitFullscreen) { /* Safari */
    document.webkitExitFullscreen();
    $(".closeicon").addClass("closescreen");
    $(".openicon").removeClass("openscreen");
  } else if (document.msExitFullscreen) { /* IE11 */
    document.msExitFullscreen();
    $(".closeicon").addClass("closescreen");
    $(".openicon").removeClass("openscreen");
  }
}
$(".orderchangebg #buyshow").click(function()
{
	  $('.orderbook').addClass("buyshow");
	  $('.orderbook').removeClass("sellshow");
	  $('.orderbook').removeClass("buysellshow");
});
$(".orderchangebg #sellshow").click(function()
{
	  $('.orderbook').addClass("sellshow");
	$('.orderbook').removeClass("buyshow");
	$('.orderbook').removeClass("buysellshow");
});
$(".orderchangebg #buysellshow").click(function()
{
	  $('.orderbook').addClass("buysellshow");
	  $('.orderbook').removeClass("buyshow");
	  $('.orderbook').removeClass("sellshow");	
});


	
function readURL(input) {
		if (input.files && input.files[0]) {
		var reader = new FileReader();
		reader.onload = function(e) {
		  $('#profile').attr('src', e.target.result);
		}
		reader.readAsDataURL(input.files[0]);
		}
		}

		$("#file_input_file").change(function() {
		$("#profilename").text(this.files[0].name);
		readURL(this);
});

function myCopyFunc1() 
{
	$('#btcaddres').attr('readonly', false);
	var copyText = document.getElementById("btcaddres");
	copyText.select();
	document.execCommand("Copy");
	var tooltip = document.getElementById("myTooltip");
	tooltip.innerHTML = "Copied!";
	return false;
}


$('[data-toggle=datepicker1]').each(function() {
	var target = $(this).data('target-name');
	var t = $('input[name=' + target + ']');
	t.datepicker({
		format: 'yy-mm-dd',
		endDate: '-1d',
		autoclose: true
	});
	$(this).on("click", function() {
		t.datepicker("show");
	});
});
$('[data-toggle=datepicker2]').each(function() {
	var target = $(this).data('target-name');
	var t = $('input[name=' + target + ']');
	t.datepicker({
		format: 'yy-mm-dd',
		startDate: '-0d',
		autoclose: true
	});
	$(this).on("click", function() {
		t.datepicker("show");
	});
});
$('[data-toggle=datepicker3]').each(function() {
	var target = $(this).data('target-name');
	var t = $('input[name=' + target + ']');
	t.datepicker({
		format: 'yy-mm-dd',
		autoclose: true
	});
	$(this).on("click", function() {
		t.datepicker("show");
	});
});



	$(".livepricedata").owlCarousel({
	  items: 1,
	  loop: false,
	  mouseDrag: true,
	  touchDrag: true,
	  pullDrag: true,
	  rewind: true,
	  autoplay: false,
	  margin: 0,
	  nav: true,
	  responsive: {
		0: {
		items: 1
		},
		470: {
		items: 1
		},
		600: {
		items: 2
		},
		1000: {
		items: 3
		},
		1200: {
			items: 3
		},
		1300: {
			items: 3
		},
		1400: {
			items: 4
		}
		} 	  
	});

	$(function() {
		$("#sidebarmarketlistCollapse").on("click", function(e) {
		  $(".marketlist").addClass("active");
		  $(".overlay").addClass("activemob");
		  e.stopPropagation();	
		});
		$(document).on("click", function(e) {
		  if (!$('.marketlist').is(e.target) && $('.marketlist').has(e.target).length === 0) {
		   $(".marketlist").removeClass("active");
		   $(".overlay").removeClass("activemob");
		  }
		});
	  });
	  
	  $('#closemarketicon').click(function()
	  {
		  $(".marketlist").removeClass('active');
	  });
	  