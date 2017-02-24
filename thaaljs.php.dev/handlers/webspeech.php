<?php
namespace handlers\webspeech;
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
$(document).ready(function(){
	var SpeechRecognition = SpeechRecognition || webkitSpeechRecognition
	var SpeechGrammarList = SpeechGrammarList || webkitSpeechGrammarList
	var SpeechRecognitionEvent = SpeechRecognitionEvent || webkitSpeechRecognitionEvent

	var colors = [ 'aqua' , 'azure' , 'beige', 'bisque', 'black', 'blue', 'brown', 'chocolate', 'coral', 'crimson', 'cyan', 'fuchsia', 'ghostwhite', 'gold', 'goldenrod', 'gray', 'green', 'indigo', 'ivory', 'khaki', 'lavender', 'lime', 'linen', 'magenta', 'maroon', 'moccasin', 'navy', 'olive', 'orange', 'orchid', 'peru', 'pink', 'plum', 'purple', 'red', 'salmon', 'sienna', 'silver', 'snow', 'tan', 'teal', 'thistle', 'tomato', 'turquoise', 'violet', 'white', 'yellow'];
	var grammar = '#JSGF V1.0; grammar colors; public <color> = ' + colors.join(' | ') + ' ;'

	var recognition = new SpeechRecognition();
	var speechRecognitionList = new SpeechGrammarList();
	speechRecognitionList.addFromString(grammar, 1);
	recognition.grammars = speechRecognitionList;
	//recognition.continuous = false;
	recognition.lang = 'en-US';
	recognition.interimResults = false;
	recognition.maxAlternatives = 1;

	var diagnostic = document.querySelector('.output');
	var bg = document.querySelector('html');
	var hints = document.querySelector('.hints');

	var colorHTML= '';
	colors.forEach(function(v, i, a){
		console.log(v, i);
		colorHTML += '<span style="background-color:' + v + ';"> ' + v + ' </span>';
	});
	hints.innerHTML = 'Tap/click then say a color to change the background color of the app. Try '+ colorHTML + '.';

	document.body.onclick = function() {
		recognition.start();
		console.log('Ready to receive a color command.');
	}

	recognition.onresult = function(event) {
		// The SpeechRecognitionEvent results property returns a SpeechRecognitionResultList object
		// The SpeechRecognitionResultList object contains SpeechRecognitionResult objects.
		// It has a getter so it can be accessed like an array
		// The [last] returns the SpeechRecognitionResult at the last position.
		// Each SpeechRecognitionResult object contains SpeechRecognitionAlternative objects that contain individual results.
		// These also have getters so they can be accessed like arrays.
		// The [0] returns the SpeechRecognitionAlternative at position 0.
		// We then return the transcript property of the SpeechRecognitionAlternative object

		var last = event.results.length - 1;
		var color = event.results[last][0].transcript;

		diagnostic.textContent = 'Result received: ' + color + '.';
		bg.style.backgroundColor = color;
		console.log('Confidence: ' + event.results[0][0].confidence);
	}

	recognition.onspeechend = function() {
		recognition.stop();
	}

	recognition.onnomatch = function(event) {
		diagnostic.textContent = "I didn't recognise that color.";
	}

	recognition.onerror = function(event) {
		diagnostic.textContent = 'Error occurred in recognition: ' + event.error;
	}
})
</script>
</head>
<body>
<h1>Speech color changer</h1>
<p class="hints"></p>
<div><p class="output"><em>...diagnostic messages</em></p></div>
</body>
</html>