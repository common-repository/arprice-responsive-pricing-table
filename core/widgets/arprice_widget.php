<?php
class arpricelite_widget extends WP_Widget {

	function __construct() {
		$widget_ops = array( 'description' => esc_html__( 'Display Pricing Table', 'arprice-responsive-pricing-table' ) );
		parent::__construct( 'arpricelite_widget', esc_html__( 'ARPrice Lite', 'arprice-responsive-pricing-table' ), $widget_ops );
	}

	function form( $instance ) {
		global $arpricelite_class, $wpdb;
		$instance        = wp_parse_args(
			(array) $instance,
			array(
				'title' => false,
				'table' => false,
			)
		);

		$tables      = $wpdb->get_results( $wpdb->prepare( 'SELECT ID, table_name FROM ' . $wpdb->prefix . 'arplite_arprice WHERE status = %s and is_template != %d', array( 'published', '1' ) ) );

		
		if ( ! empty( $tables ) ) { ?>
			<p><label for="<?php echo $this->get_field_id( 'title' ); //phpcs:ignore ?>"><?php esc_html_e( 'Title', 'arprice-responsive-pricing-table' ); ?>:</label>
			<input type="text" class="widefat" id="<?php echo $this->get_field_id( 'title' ); //phpcs:ignore ?>" name="<?php echo $this->get_field_name( 'title' ); ?>" value="<?php echo esc_attr( stripslashes( $instance['title'] ) ); ?>" /></p>
			<p>
				<label for="<?php echo $this->get_field_id( 'table' ); //phpcs:ignore ?>"><?php esc_html_e( 'Table', 'arprice-responsive-pricing-table' ); ?>:</label>
				<select name="<?php echo esc_attr( $this->get_field_id('title') ); //phpcs:ignore ?>" id="<?php echo esc_attr( $this->get_field_id('table') ); ?>" class="arp_table_list">
				<?php
					foreach ( $tables as $table ) {
				?>
						<option value="<?php echo esc_attr( $table->ID ); ?>" <?php selected( $table->ID, $instance['table'] ); ?> ><?php echo esc_html( $table->table_name ); ?></option>
				<?php
					}
				?>
				</select>
			</p>
		<?php } else { ?>
			<p><label><?php esc_html_e( 'Pricing Table Not Found', 'arprice-responsive-pricing-table' ); ?></label></p>
		<?php } ?>
		<?php
	}

	function update( $new_instance, $old_instance ) {
		return $new_instance;
	}

	function widget( $args, $instance ) {

		extract( $args );

		global $wpdb,$arpricelite_form,$arpricelite_analytics,$arpricelite_img_css_version;
		$table_data = $wpdb->get_row( $wpdb->prepare( 'SELECT * FROM ' . $wpdb->prefix . 'arplite_arprice WHERE ID = %d', $instance['table'] ) );

		if ( ! $table_data ) {
			return;
		}

		$title = apply_filters( 'widget_title', empty( $instance['title'] ) ? '' : $instance['title'] );
		echo $before_widget; //phpcs:ignore
		echo '<div class="arp_widget_table">';
		if ( $title ) {
			echo $before_title . esc_html( $title ) . $after_title; //phpcs:ignore
		}

		$newvalues_enqueue = $arpricelite_form->get_table_enqueue_data( array( $instance['table'] ) );

		$formids   = array();
		$formids[] = $instance['table'];

		$newvalarr = array();

		if ( isset( $formids ) and is_array( $formids ) && count( $formids ) > 0 ) {
			foreach ( $formids as $newkey => $newval ) {
				if ( stripos( $newval, ' ' ) !== false ) {
					$partsnew    = explode( ' ', $newval );
					$newvalarr[] = $partsnew[0];
				} else {
					$newvalarr[] = $newval;
				}
			}
		}

		if ( is_array( $newvalues_enqueue ) && count( $newvalues_enqueue ) > 0 ) {
			$to_google_map = 0;
			$templates     = array();
			$is_template   = 0;
			foreach ( $newvalues_enqueue as $newqnqueue ) {

				if ( $newqnqueue['template_name'] != 0 ) {
					$templates[] = $newqnqueue['template_name'];
				} else {
					$templates[] = $newvalarr[0];
				}

				if ( ! empty( $newqnqueue['is_template'] ) ) {
					$is_template = $newqnqueue['is_template'];
				}
			}

			$templates = array_unique( $templates );

			if ( $templates ) {
				wp_enqueue_script( 'arplite_front_js' );

				wp_enqueue_style( 'arplite_front_css' );
				wp_enqueue_style( 'arp_fontawesome_css' );

				foreach ( $templates as $template ) {
					if ( $is_template ) {
						wp_register_style( 'arplitetemplate_' . $template . '_css', ARPLITE_PRICINGTABLE_URL . '/css/templates/arplitetemplate_' . $template . '_v' . $arpricelite_img_css_version . '.css', array(), $arpricelite_img_css_version );
						wp_enqueue_style( 'arplitetemplate_' . $template . '_css' );
						do_action( 'arplite_front_inline_css', $template, 0 );
					} else {
						wp_register_style( 'arplitetemplate_' . $template . '_css', ARPLITE_PRICINGTABLE_UPLOAD_URL . '/css/arplitetemplate_' . $template . '.css', array(), $arpricelite_img_css_version );
						wp_enqueue_style( 'arplitetemplate_' . $template . '_css' );
						do_action( 'arplite_front_inline_css', $template, 0 );
					}
				}
			}
		}
		echo $arpricelite_analytics->arplite_Shortcode( array( 'id' => $instance['table'] ) ); //phpcs:ignore

		echo '</div>';
		echo $after_widget; //phpcs:ignore
	}
}
?>
