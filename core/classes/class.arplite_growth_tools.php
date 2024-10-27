<?php

class arplite_growth_tools {

	function __construct() {

        add_action('wp_ajax_arprice_get_bookingpress', array( $this, 'arprice_get_bookingpress_func'));     

        add_action('wp_ajax_arprice_get_armember', array( $this, 'arprice_get_armember_func'));         

        add_action('wp_ajax_arprice_get_arforms', array( $this, 'arprice_get_arforms_func'));   
    }
    function arprice_get_bookingpress_func(){
        if ( ! file_exists( WP_PLUGIN_DIR . 'bookingpress-appointment-booking/bookingpress-appointment-booking.php' ) ) {
        
            if ( ! function_exists( 'plugins_api' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            }
            $response = plugins_api(
                'plugin_information',
                array(
                    'slug'   => 'bookingpress-appointment-booking',
                    'fields' => array(
                        'sections' => false,
                        'versions' => true,
                    ),
                )
            );
            if ( ! is_wp_error( $response ) && property_exists( $response, 'versions' ) ) {
                if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                }
                $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                $source   = ! empty( $response->download_link ) ? $response->download_link : '';
                
                if ( ! empty( $source ) ) {
                    if ( $upgrader->install( $source ) === true ) {
                        activate_plugin( 'bookingpress-appointment-booking/bookingpress-appointment-booking.php' );
                        $arm_install_activate = 1; 
                    }
                }
            } else {
                $source_url = 'https://www.bookingpress.com/bookingpress/plugin_install_api.php';
                $get_custom_response = wp_remote_get( $source_url, array( 'method' => 'GET') );
                if(!is_wp_error($get_custom_response)) {
                    $get_custom_response_body = json_decode(wp_remote_retrieve_body($get_custom_response));
                    if(is_object($get_custom_response_body) && !empty($get_custom_response_body))
                    {
                        if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                        }
                        $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                        $source   = !empty( $get_custom_response_body->download_link ) ? $get_custom_response_body->download_link : '';
                        
                        if ( ! empty( $source ) ) {
                            if ( $upgrader->install( $source ) === true ) {
                                activate_plugin( 'bookingpress-appointment-booking/bookingpress-appointment-booking.php' );
                                $arm_install_activate = 1;
                            }
                        }
                    }
                }
            }
        }       
    }
    function arprice_get_armember_func(){   
        if ( ! file_exists( WP_PLUGIN_DIR . '/armember-membership/armember-membership.php' ) ) {
        
            if ( ! function_exists( 'plugins_api' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            }
            $response = plugins_api(
                'plugin_information',
                array(
                    'slug'   => 'armember-membership',
                    'fields' => array(
                        'sections' => false,
                        'versions' => true,
                    ),
                )
            );
            if ( ! is_wp_error( $response ) && property_exists( $response, 'versions' ) ) {
                if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                }
                $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                $source   = ! empty( $response->download_link ) ? $response->download_link : '';
                
                if ( ! empty( $source ) ) {
                    if ( $upgrader->install( $source ) === true ) {
                        activate_plugin( 'armember-membership/armember-membership.php' );
                        $arm_install_activate = 1; 
                    }
                }
            } else {
                $source_url = 'https://www.armemberplugin.com/armember_lite_version/lite_plugin_install_api.php';
                $get_custom_response = wp_remote_get( $source_url, array( 'method' => 'GET') );
                if(!is_wp_error($get_custom_response)) {
                    $get_custom_response_body = json_decode(wp_remote_retrieve_body($get_custom_response));
                    if(is_object($get_custom_response_body) && !empty($get_custom_response_body))
                    {
                        if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                        }
                        $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                        $source   = !empty( $get_custom_response_body->download_link ) ? $get_custom_response_body->download_link : '';
                        
                        if ( ! empty( $source ) ) {
                            if ( $upgrader->install( $source ) === true ) {
                                activate_plugin( 'armember-membership/armember-membership.php' );
                                $arm_install_activate = 1;
                            }
                        }
                    }
                }
            }
        }  
    }
    function arprice_get_arforms_func (){  
        if ( ! file_exists( WP_PLUGIN_DIR . '/arforms-form-builder/arforms-form-builder.php' ) ) {
    
            if ( ! function_exists( 'plugins_api' ) ) {
                require_once ABSPATH . 'wp-admin/includes/plugin-install.php';
            }
            $response = plugins_api(
                'plugin_information',
                array(
                    'slug'   => 'arforms-form-builder',
                    'fields' => array(
                        'sections' => false,
                        'versions' => true,
                    ),
                )
            );
            if ( ! is_wp_error( $response ) && property_exists( $response, 'versions' ) ) {
                if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                    require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                }
                $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                $source   = ! empty( $response->download_link ) ? $response->download_link : '';
                
                if ( ! empty( $source ) ) {
                    if ( $upgrader->install( $source ) === true ) {
                        activate_plugin( 'arforms-form-builder/arforms-form-builder.php' );
                        $arf_install_activate = 1; 
                    }
                }
            } else {
                $source_url = 'https://www.arformsplugin.com/arf_misc/arforms-form-builder/arforms-form-builder-latest.zip';
                $get_custom_response = wp_remote_get( $source_url, array( 'method' => 'GET') );
                if(!is_wp_error($get_custom_response)) {
                    $get_custom_response_body = json_decode(wp_remote_retrieve_body($get_custom_response));
                    if(is_object($get_custom_response_body) && !empty($get_custom_response_body))
                    {
                        if ( ! class_exists( 'Plugin_Upgrader', false ) ) {
                            require_once ABSPATH . 'wp-admin/includes/class-wp-upgrader.php';
                        }
                        $upgrader = new \Plugin_Upgrader( new \Automatic_Upgrader_Skin() );
                        $source   = !empty( $get_custom_response_body->download_link ) ? $get_custom_response_body->download_link : '';
                        
                        if ( ! empty( $source ) ) {
                            if ( $upgrader->install( $source ) === true ) {
                                activate_plugin( 'arforms-form-builder/arforms-form-builder.php' );
                                $arf_install_activate = 1;
                            }
                        }
                    }
                }
            }
        }
    }
}
?>
