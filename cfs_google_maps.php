<?php

if ( ! defined( 'ABSPATH' ) ) {
    exit;
}

class cfs_google_maps extends cfs_field {

    function __construct() {
        $this->name = 'google_maps';
        $this->label = __( 'Google Maps', 'cfs-google-maps' );
        $this->google_maps_code_inserted = false;
    }

    function html( $field ) {
        add_action( 'admin_footer', array( $this, 'cfs_google_maps_code' ) );

        $lat_lng = empty( $field->value ) ? '-36.191092,-16.083984' : $field->value;
        ?>
        <div class="cfs-google-maps-field-wrapper">
            <div class="cfs-google-maps-input-location" style="margin-bottom:10px;">
                <input type="text" name="" class="cfs-google-maps-address" value="" style="width:463px;" />
                <input class="cfs-google-maps-button button" type="button" value="<?php echo __( 'Search location', 'cfs-google-maps' ); ?>" />
            </div>
            <div class="cfs-google-maps-canvas" style="width:100%;height:300px;"></div>
            <input type="hidden" name="<?php echo $field->input_name; ?>" class="<?php echo $field->input_class; ?>" value="<?php echo $lat_lng ?>" />
        </div>
        <?php
    }

    function cfs_google_maps_code() {

        // Exit early if the js code has already been inserted
        if ( $this->google_maps_code_inserted ) {
            return;
        }
        $this->google_maps_code_inserted = true;

        echo '<script src="//maps.googleapis.com/maps/api/js?libraries=places&key=' . apply_filters( 'cfs_google_maps_api_key', '' ) . '"></script>';
        echo '<script src="' . plugins_url( 'cfs_google_maps.js', __FILE__ ) . '"></script>';
        echo '<link rel="stylesheet" type="text/css" href="' . plugins_url( 'cfs_google_maps.css', __FILE__ ) . '" />';
    }
}
