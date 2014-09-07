<?php

class cfs_google_maps extends cfs_field
{

    function __construct() {
        $this->name = 'google_maps';
        $this->label = __( 'Google Maps', 'cfs' );
    }


    function html( $field ) {
        $latlng = empty( $field->value ) ? '40.4,-98.7' : $field->value;
    ?>
        <script>
        (function($) {
            $(function() {
                var map = new google.maps.Map(document.getElementById('map_canvas'), {
                    zoom: 4,
                    center: new google.maps.LatLng(<?php echo $latlng; ?>),
                    mapTypeId: google.maps.MapTypeId.ROADMAP
                });

                var marker = new google.maps.Marker({
                    map: map,
                    draggable: true,
                    position: new google.maps.LatLng(<?php echo $latlng; ?>)
                });

                google.maps.event.addListener(map, 'click', function(event) {
                    marker.setPosition(event.latLng);
                    $('#map_canvas').closest('.field').find('input.google_maps').val(event.latLng.toUrlValue());
                });

                google.maps.event.addListener(marker, 'click', function(event) {
                    marker.setPosition(null);
                    $('#map_canvas').closest('.field').find('input.google_maps').val('');
                });

                google.maps.event.addListener(marker, 'dragend', function(event) {
                    $('#map_canvas').closest('.field').find('input.google_maps').val(event.latLng.toUrlValue());
                });
								
				var cfsMapsBtn = $('#cfs_maps_button');
				var cfsMapsAdd = $('#cfs_maps_address');
				
				cfsMapsBtn.click(function() {
					if ($(this).is(':disabled') || !cfsMapsAdd.val()) {
						return false;
					}
		
					$(this).attr('disabled', 'disabled').val('<?php echo __( 'Searching...', 'cfs' ); ?>');
					
					var geocoder = new google.maps.Geocoder();
					geocoder.geocode( {'address': cfsMapsAdd.val() }, function(results, status) {
						if (status == google.maps.GeocoderStatus.OK) {
							map.setCenter(results[0].geometry.location);
							marker.setPosition(results[0].geometry.location);
                    		$('#map_canvas').closest('.field').find('input.google_maps').val(results[0].geometry.location.toUrlValue());
						} else {
							var cfsMapsErrMsg = (status == google.maps.GeocoderStatus.ZERO_RESULTS) ? '<?php echo __( 'Could not locate address.', 'cfs' ); ?>' : '<?php echo __( 'There was an error while processing your request.', 'cfs' ); ?>';
							cfsMapsBtn.after('<span class="cfs_maps_err_msg" style="display:block;margin-top:5px;color:#ff0000;">' + cfsMapsErrMsg + '</span>');
							$('.cfs_maps_err_msg').delay(3000).fadeOut(200);
						}
						cfsMapsBtn.removeAttr('disabled').val('<?php echo __( 'Search location', 'cfs' ); ?>');
					})
				});
				$('#cfs_maps_address').keydown(function(e) {
					if (e.keyCode == 13) {
						cfsMapsBtn.click();
						return false;
					}
					return true;
				});				
				
            });
        })(jQuery);
        </script>
        <div id="map_canvas" style="width:100%; height:250px"></div>
        <input type="hidden" name="<?php echo $field->input_name; ?>" class="<?php echo $field->input_class; ?>" value="<?php echo $field->value; ?>" />
        <input type="text" name="" id="cfs_maps_address" value="" style="max-width:463px;margin-top:10px"/> <input id="cfs_maps_button" type="button" class="button" value="<?php echo __( 'Search location', 'cfs' ); ?>" style="margin-top:10px;" />
    <?php
    }


    function input_head() {
    ?>
        <script src="https://maps.googleapis.com/maps/api/js?sensor=false"></script>
    <?php
    }
}
