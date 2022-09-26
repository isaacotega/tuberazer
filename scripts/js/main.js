$(document).ready(function() {
	
	try {
		
		Android;
		
	}
	
	catch(err) {
		
		if(navigator.userAgent.toLowerCase().indexOf("android") !== -1) {
	
//			website["templates"]["bigDisplay"].show('<br> <label class="comment"><br><br><b>TubeRazer</b> feels better on the app. Install the android app on your phone and enjoy unlimited experience!</label> <br><br><br><br><br> <button class="bigButton" onclick=\'downloadApp("android");\'><svg id="installSvg" xmlns="http://www.w3.org/2000/svg" width="30" height="30" viewBox="0 0 30 30" style="margin: 0 15px;"><path d="M12 21l-8-9h6v-12h4v12h6l-8 9zm9-1v2h-18v-2h-2v4h22v-4h-2z"/></svg>Install</button>', "Did you know?");
			
		}
		
	}

});

	var loader = {
		show: function() {
			$("#body #loader").css({
				display: "block"
			});
		},
		hide: function() {
			$("#body #loader").css({
				display: "none"
			});
		}
	}
	
var website = {
	templates: [],
	youtube: {
		apiKey: "AIzaSyCviWLPH2wE-4BlQMPvMU3aVVsfxpXWmg8"
	},
	user: {
		device: {}
	}
};

	website["templates"]["bigDisplay"] = {
		show: function(content, topic) {
			
			var heading = '<label id="topic">' + (topic !== undefined ? topic : "") + '</label><br><br>';
		
			$("#bigDisplay").show(100);
			
			$("#bigDisplay #main").html(heading + content);
		
			$("#bigDisplay #background").click(function() {
				
				website["templates"]["bigDisplay"].hide();
			
			});
		
		},
		hide: function() {
			
			$("#bigDisplay").hide(100);
			
			$("#bigDisplay #main").html("");
		
		}
	}
	
	
	function toast(text) {
	
		$("#toast").css({
			display: "block",
			bottom: "4cm",
			opacity: "1"
		}).html(text);
		
		setTimeout(function() {
		
			$("#toast").css({
				display: "none",
				bottom: "2cm",
				opacity: "0"
			}).html(text);
		
		}, 2000);
	
	}
	
	var getDeviceType = function() {

		const ua = navigator.userAgent;

		if (/(tablet|ipad|playbook|silk)|(android(?!.*mobi))/i.test(ua)) {

			return "tablet";
		
		}
		if (
    /Mobile|iP(hone|od)|Android|BlackBerry|IEMobile|Kindle|Silk-Accelerated|(hpw|web)OS|Opera M(obi|ini)/.test(
      		ua
    		)
  ) {
  
			return "mobile";
		
		}

		return "desktop";

	};

	website["user"]["device"]["type"] = getDeviceType();
	
	function downloadApp(os) {
	
		if(os == "android") {
			
			website["templates"]["bigDisplay"].hide();
		
			toast("Downloading . . .");
		
 			$("#downloaderIframe").attr("src", "https://tuberazer.com/download-app/android/begin");
 				
		}
	
	}
	
//	alert(navigator.userAgent.toLowerCase());
	