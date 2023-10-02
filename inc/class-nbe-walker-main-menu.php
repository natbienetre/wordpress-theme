<?php
/**
 * Nat'Bien-Être Theme Customizer
 *
 * @package Nat'Bien-Être
 */

/**
 * Custom walker for the main menu.
 */
class NBE_Walker_Main_Menu extends Walker_Nav_Menu {
	/**
	 * Index of the inputs.
	 *
	 * @var array(int)
	 */
	protected $input_indices = array();

	/**
	 * Add a label to top-level menu items that has sub-menus.
	 *
	 * @param int    $depth Depth.
	 * @param object $index Index of the input.
	 * @return string Nav menu item start element.
	 */
	protected function sub_menu_toggle_label( $depth, $index ) {
		return '<label for="' . esc_attr( $index ) . '" class="menu-toggle">'
					. '<span class="icon icon-plus material-symbols-outlined">expand_more</span>'
					. '<span class="icon icon-minus material-symbols-outlined">expand_less</span>'
					. '<span class="screen-reader-text">'
						/* translators: Hidden accessibility text. */
						. esc_html__( 'Open menu', 'natbienetre' )
					. '</span>'
				. '</label>';
	}

	/**
	 * Add a button to top-level menu items that has sub-menus.
	 *
	 * @param int    $depth Depth.
	 * @param string $id    Index of the input.
	 * @return string Nav menu item start element.
	 */
	protected function sub_menu_toggle_input( $depth, $id ) {
		return '<input
			id="' . esc_attr( $id ) . '"
			name="' . esc_attr( $id ) . '"
			type="checkbox"
			class="menu-toggle-input"
		/>';
	}

	/**
	 * Starts the list before the elements are added.
	 * 
	 * @param string    $output Used to append additional content (passed by reference).
	 * @param WP_Post   $data_object  Depth of menu item. Used for padding.
	 * @param int       $depth  Depth of menu item. Used for padding.
	 * @param ?stdClass $args   An object of wp_nav_menu() arguments.
	 * @param int       $current_object_id   Menu item ID.
	 */
	public function start_el( &$output, $data_object, $depth = 0, $args = null, $current_object_id = 0 ) {
		if ( ! isset( $args->has_children ) || $args->has_children ) {
			if ( ! isset( $this->input_indices[ $depth ] ) ) {
				$this->input_indices[ $depth ] = 0;
			}
			$index = ++$this->input_indices[ $depth ];
			
			$args->before = $this->sub_menu_toggle_input( $depth, "menu-item-{$depth}-{$index}" );
		}

		parent::start_el( $output, $data_object, $depth, $args, $current_object_id );
	}

	/**
	 * Ends the list of after the elements are added.
	 *
	 * @since 3.0.0
	 *
	 * @see Walker::end_lvl()
	 *
	 * @param string   $output Used to append additional content (passed by reference).
	 * @param int      $depth  Depth of menu item. Used for padding.
	 * @param stdClass $args   An object of wp_nav_menu() arguments.
	 */
	public function end_lvl( &$output, $depth = 0, $args = null ) {
		parent::end_lvl( $output, $depth, $args );

		$index   = $this->input_indices[ $depth ]++;
		$output .= $this->sub_menu_toggle_label( $depth, "menu-item-{$depth}-{$index}" );
	}

}
