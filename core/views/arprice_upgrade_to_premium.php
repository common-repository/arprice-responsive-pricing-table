<?php
// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

function arp_upgrade_to_premium_menu() {

	global $arplite_pricingtable;

	$arp_current_date = current_time('timestamp', true );
	$arp_sale_start_time = '1700483400';
	$arp_sale_end_time = '1701541800';
	
	if( $arp_current_date >= $arp_sale_start_time && $arp_current_date <= $arp_sale_end_time ){
		$page_hook = add_submenu_page( 'arpricelite', esc_html__( 'Black Friday Sale', 'arprice-responsive-pricing-table' ), esc_html__( 'Black Friday Sale', 'arprice-responsive-pricing-table' ), 'arplite_view_pricingtables', 'arpricelite&amp;arpricelite_show_deal=yes', 'arp_black_friday_deal' );
	} else {
		$page_hook = add_submenu_page( 'arpricelite', esc_html__( 'Upgrade to Premium', 'arprice-responsive-pricing-table' ), esc_html__( 'Upgrade to Premium', 'arprice-responsive-pricing-table' ), 'arplite_view_pricingtables', 'arplite_upgrade_to_premium', 'arp_upgrade_to_premium' );
	}
	add_action( 'load-' . $page_hook, 'arp_upgrade_ob_start' );
}
add_action( 'admin_menu', 'arp_upgrade_to_premium_menu', '28' );

function arp_upgrade_ob_start() {
	ob_start();
}

function arp_black_friday_deal(){
	
}

function arp_upgrade_to_premium() {
	global $arpricelite_version;
	wp_redirect( 'https://www.arpriceplugin.com/premium/upgrade_to_premium.php?rdt=t1&arp_version=' . $arpricelite_version . '&arp_request_version=' . get_bloginfo( 'version' ), 301 );
	exit();
}

function arp_upgrade_to_premium_menu_js() {
	 global $arpricelite_version;

	wp_register_script( 'arplite_upgrade_js', ARPLITE_PRICINGTABLE_URL . '/js/arplite_upgrade_premium.js', array( 'jquery' ), $arpricelite_version );

	wp_enqueue_script( 'arplite_upgrade_js' );
}
add_action( 'admin_footer', 'arp_upgrade_to_premium_menu_js' );

