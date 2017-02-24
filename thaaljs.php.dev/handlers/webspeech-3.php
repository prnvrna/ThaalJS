<?php
namespace handlers\webspeech_3;
# getting data from stdin (we can control all parts of the stream)
$request_body = file_get_contents('php://stdin');
# sending response headers
echo 200, PHP_EOL;
echo 'Content-Type: text/html; charset=utf-8', PHP_EOL;
echo $thaaljs['delimeter'];
?>
<!DOCTYPE html>
<html>
<head>
<meta charset='utf-8' />
<meta http-equiv='X-UA-Compatible' content='IE=edge' />
<title>DW/IO - DEV possibilities, revisited</title>
<meta name='description' content='DEV possibilities, revisited' />
<meta name='mobile-web-app-capable' content='yes' />
<meta name='theme-color' content='#222222' />
<meta name='HandheldFriendly' content='True' />
<meta name='viewport' content='width=device-width, initial-scale=1.0' />
<script src='//cdn.jsdelivr.net/g/jquery@3.1.1,angularjs@1.6.0,modernizr@2.8.3,sammy@0.7.4,jquery.appear@0.3.3'></script>
<script>
var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
var recognition = new SpeechRecognition();
recognition.lang = 'en-US';
recognition.interimResults = false;
recognition.maxAlternatives = 1;
// recognition.continuous = true;

recognition.onresult = function(event){
	/*for(var i in event.results){
		$('body > div').append('<div>'+event.results[i][0].transcript+'</div>')
	}*/
	$('body > div').append('<div>'+event.results[event.results.length-1][0].transcript+'</div>')
}

recognition.onspeechend = function(){
	recognition.stop();
}

recognition.onerror = function(event){
	// $('body > div').html('Error occurred in recognition: ' + event.error);
}

function hey(){
	recognition.start();
}
</script>
<style>
body{
	text-align: center;
}
button{
	margin-top: 50px;
	margin-bottom: 10px;
}
</style>
</head>
<body>
<button onclick='hey()'>Hi, I say!</button>
<div></div>
</body>
</html>