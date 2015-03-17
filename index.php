<?

if(isset($_POST['less'])):

	#sleep(1);

	header("Content-type: text/plain");

	require('lessc.inc.php');

	$lesstext = stripslashes(trim($_POST['less']));
	
	try {
		$less = new lessc();
		echo $less->parse($lesstext);
	}
	catch(exception $err)
	{
		echo 'Sintassi errata '.$err->getMessage();
	}
	exit(0);

endif;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LessCSS to CSS</title>
<style>
h1 {
	text-align:center;
	font-size:20px;
}
#content {
	width:100%;
	margin:0 auto;
}
#copy {
	position:fixed;
	z-index:500;
	right:-5px;
	top:-5px;
	padding:4px 8px;
	background: #fff;
	border:2px solid #c5cdd4;
	border-radius:.7em;
	-moz-border-radius: .7em;
	-webkit-border-radius: .7em;
	filter: alpha(opacity=80);
	-khtml-opacity: 0.8;
	-moz-opacity: 0.8;
	opacity: 0.8;
}
.wrap {
	float:left;
	width:50%;
	text-align:center;
	border:0px solid blue;
}
textarea {
	background:#eee;
	padding: 10px;
}
#loader {
	display:none;
	position:fixed;
	z-index:100;
	bottom:50%;
	left:50%;
	margin:-20px 0 0 -70px;
	height:40px;
	width:140px;
	text-align:center;
	opacity:0.7;
	border-radius: 0.4em;
}
.loading {
	background:url('loading.gif') no-repeat center center #fff;
}
</style>
</head>

<body>

<h1>Lesscss to Css Converter</h1>

<div id="content">

<div id="loader" class="loading"><br />Conversion...</div>

<div class="wrap">
<label>LessCSS: </label><br />
<textarea id="lesscode" class="code" rows="30" cols="50">
@custom_red: '#FF0000';

#page {
  background-color: @custom_red;
  h1 {
    font-size: 4em;
  }
  a {
    color: @custom_red;
  }
  .box {
    border: 1px solid @custom_red;
    h2 {
      font-size: 2em;
    }
  }
}

.rounded_corners (@radius: 5px) {
  -moz-border-radius: @radius;
  -webkit-border-radius: @radius;
  border-radius: @radius;
}

#header {
  .rounded_corners;
}

#footer {
  .rounded_corners(10px);
}
</textarea>
</div>
<div class="wrap">
	<label>CSS: </label><br />
	<textarea id="csscode" class="code" rows="30" cols="50">
	&nbsp;
	</textarea>
</div>

</div>

	<div id="copy"><a href="http://labs.easyblog.it/">Labs</a> &bull; <a rel="author" href="http://labs.easyblog.it/stefano-cudini/">Stefano Cudini</a></div>
<p>
Riferimenti: <br />
<a href="http://stacktrace.it/2010/02/introduzione-a-lesscss/" target="_blank">introduzione-a-lesscss</a>
</p>

<script type="text/javascript" src="/js/jquery-1.7.2.min.js"></script>
<!--script type="text/javascript" src="jquery.textarea-expander.min.js"></script-->
<script>
$(function() {

	$("#loader")
	.ajaxStart(function(){
		$(this).show();
	})
	.ajaxStop(function(){
		$(this).hide();
	})
	$('#lesscode')
		.focus()
		.on('mouseover', function(){ $(this).focus(); })
		.on('keydown blur', function() {
			var text = $(this).val();

			clearTimeout($(this).data('timer'));

			$(this).data('timer', setTimeout(function() {
				$.post('./',
					{less: text},
					function(css) {
					$('#csscode').text(css);
				});
			}, 300));
		}); // */
});
</script>
<script type="text/javascript" src="/labs-common.js"></script>
</body>
</html>
