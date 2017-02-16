@extends('frontend.layouts.page')

@section('title')
<title>Geografi Kabupaten Tangerang</title>
@stop
	@section('content')
		<div class="page-breadcrumbs">
			<h1 class="section-title title">Geografi</h1>
		</div>
		<div class="contact-us contact-page-two">
			<div class="map-section">
				<div id="gmap"></div>
			</div>
			<div class="contact-info">
				<h1 class="section-title title">Contact Information</h1>
				<ul class="list-inline">
					<li>
						<h2>Head Office</h2>
						<address>
							23-45A, Silictown <br>Great Country
							<p class="contact-mail"><strong>Email:</strong> <a href="#">hello@newspress.com</a></p>
							<p><strong>Call:</strong> +123 123 456 789</p>
						</address>
					</li>
					<li>
					   <h2>USA Office</h2>
						<address>
							245 North Street, <br>New York, NY
							<p class="contact-mail"><strong>Email:</strong> <a href="#">info@usa-newspress.com</a></p>
							<p><strong>Call:</strong> +123 123 456 789</p>
						</address>
					</li>
					<li>
					   <h2>UK Office</h2>
						<address>
							123, Pall Mall,<br> London England
							<p class="contact-mail"><strong>Email:</strong> <a href="#">info@uk-newspress.com</a></p>
							<p><strong>Call:</strong> +123 123 456 789</p>
						</address>
					</li>
				</ul>
			</div>
		</div>
	@stop

@section('script')
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=true"></script>
<script type="text/javascript">
	(function(){

		var map;

		map = new GMaps({
			el: '#gmap',
			lat: 42.8206606,
			lng: -75.554387,
			scrollwheel:false,
			zoom: 6,
			zoomControl : true,
			panControl : false,
			streetViewControl : false,
			mapTypeControl: false,
			overviewMapControl: false,
			clickable: false
		});

		var image = '';
		map.addMarker({
			lat: 42.8206606,
			lng: -75.554387,
			icon: image,
			animation: google.maps.Animation.DROP,
			verticalAlign: 'bottom',
			horizontalAlign: 'center',
			backgroundColor: '#d3cfcf',
			 infoWindow: {
				content: '<div class="map-info"><address>ThemeRegion<br />234 West 25th Street <br />New York</address></div>',
				borderColor: 'red',
			}
		});

		var styles = [

			{
			  "featureType": "road",
			  "stylers": [
				{ "color": "#c1c1c1" }
			  ]
			  },{
			  "featureType": "water",
			  "stylers": [
				{ "color": "#f1f1f1" }
			  ]
			  },{
			  "featureType": "landscape",
			  "stylers": [
				{ "color": "#e3e3e3" }
			  ]
			  },{
			  "elementType": "labels.text.fill",
			  "stylers": [
				{ "color": "#808080" }
			  ]
			  },{
			  "featureType": "poi",
			  "stylers": [
				{ "color": "#dddddd" }
			  ]
			  },{
			  "elementType": "labels.text",
			  "stylers": [
				{ "saturation": 1 },
				{ "weight": 0.1 },
				{ "color": "#7f8080" }
			  ]
			}

		];

	map.addStyle({
			styledMapName:"Styled Map",
			styles: styles,
			mapTypeId: "map_style"
		});

		map.setStyle("map_style");
	}());
</script>
@stop
