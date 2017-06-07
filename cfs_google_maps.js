(function($) {
    $( '.cfs-google-maps-canvas' ).each(function() {
        var $map = $( this ),
        $input = $map.closest( '.cfs-google-maps-field-wrapper' ).find( 'input[type="hidden"]' ),
        lat_lng = $input.val().split( ',' ),
        lat = parseFloat( lat_lng[0] ),
        lng = parseFloat( lat_lng[1] ),
        map = new google.maps.Map( $map[0], {
            zoom: 15,
            center: new google.maps.LatLng( lat, lng ),
            mapTypeId: google.maps.MapTypeId.ROADMAP
        } ),
        marker = new google.maps.Marker({
            map: map,
            draggable: true,
            position: new google.maps.LatLng( lat, lng )
        });

        $map.data( 'map', map );
        $map.data( 'marker', marker );

        google.maps.event.addListener( map, 'click', function( event ) {
            marker.setPosition( event.latLng );
            $input.val( event.latLng.toUrlValue() );
        } );

        google.maps.event.addListener( marker, 'click', function( event ) {
            marker.setPosition( null );
            $input.val('');
        } );

        google.maps.event.addListener( marker, 'dragend', function( event ) {
            $input.val( event.latLng.toUrlValue() );
        } );
    });

    $( '.cfs-google-maps-button' ).click(function() {
        var $wrapper = $( this ).closest( '.cfs-google-maps-field-wrapper' ),
        $botao = $( this ),
        $address = $wrapper.find( '.cfs-google-maps-address' ),
        $input = $wrapper.find( 'input[type="hidden"]' ),
        $map = $wrapper.find( '.cfs-google-maps-canvas' ),
        map = $map.data( 'map' ),
        marker = $map.data( 'marker' );

        if ( $( this ).is( ':disabled' ) || ! $address.val() ) {
            return false;
        }

        $( this ).attr( 'disabled', 'disabled' ).val( 'Searching...' );

        var geocoder = new google.maps.Geocoder();
        geocoder.geocode( { 'address': $address.val() }, function( results, status ) {
            if ( status == google.maps.GeocoderStatus.OK ) {
                map.setCenter( results[0].geometry.location );
                marker.setPosition( results[0].geometry.location );
                $input.val( results[0].geometry.location.toUrlValue() );
            } else {
                var maps_err_msg = ( status == google.maps.GeocoderStatus.ZERO_RESULTS ) ? 'Could not locate address.' : 'There was an error while processing your request.';
                $botao.after( '<span class="cfs_maps_err_msg" style="display:block;margin-top:5px;color:#ff0000;">' + maps_err_msg + '</span>' );
                $( '.cfs_maps_err_msg' ).delay( 3000 ).fadeOut( 200 );
            }
            $botao.removeAttr( 'disabled' ).val( 'Search location' );
        })
    });

    $( '.cfs-google-maps-address' ).keydown(function(e) {
        var $botao = $( this ).closest( '.cfs-google-maps-field-wrapper' ).find( '.cfs-google-maps-button' );
        if ( e.keyCode == 13 ) {
            $botao.trigger( 'click' );
            return false;
        }
        return true;
    });

    $( '.cfs-tab' ).click(function() {
        var rel = $( this ).attr( 'rel' ),
        $tab_content = $( '.cfs-tab-content-' + rel ),
        $maps = $tab_content.find( '.cfs-google-maps-canvas' );

        setTimeout( function() {
            $maps.each(function() {
                lat_lng = $maps.closest( '.cfs-google-maps-field-wrapper' ).find( 'input[type="hidden"]' ).val().split( ',' ),
                lat = parseFloat( lat_lng[0] ),
                lng = parseFloat( lat_lng[1] );

                var map = $( this ).data( 'map' );
                google.maps.event.trigger( map, 'resize' );
                map.setCenter( new google.maps.LatLng( lat, lng ) );
            });
        }, 1200 );
    });
})( jQuery );
