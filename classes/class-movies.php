<?php
/**
 * ExtantDemo Movies Custom Post Type Class
 *
 * @package ExtantDemo
 */

class ExtantDemo_Movies {

	public function __construct() {

		add_action( 'init', array( $this, 'movies_post_type_setup' ) );
		add_action( 'init', array( $this, 'movies_genre_taxonomy_setup' ) );
		add_action( 'init', array( $this, 'movies_year_taxonomy_setup' ) );

		add_action( 'admin_init', array( $this, 'extant_add_movie_meta_boxes' ) );
		add_action( 'save_post', array( $this, 'extant_save_movie_meta_boxes' ) );
		

		//add_action( 'admin_enqueue_scripts', array( $this, 'assets' ) );
	}

	/**
	 * Register the 'Movie' CPT
	 *
	 * @return void
	 */
	public function movies_post_type_setup() {
		$labels = array(
			'name'               => esc_html_x( 'Movies', 'post type general name', 'extant-demo' ),
			'singular_name'      => esc_html_x( 'Movie', 'post type singular name', 'extant-demo' ),
			'add_new'            => esc_html_x( 'Add New', 'post type general name', 'extant-demo' ),
			'add_new_item'       => esc_html__( 'Add New Movie', 'extant-demo' ),
			'edit_item'          => esc_html__( 'Edit Movie', 'extant-demo' ),
			'new_item'           => esc_html__( 'New Movie', 'extant-demo' ),
			'all_items'          => esc_html__( 'All Movies', 'extant-demo' ),
			'view_item'          => esc_html__( 'View Movie', 'extant-demo' ),
			'search_items'       => esc_html__( 'Search Movies', 'extant-demo' ),
			'not_found'          => esc_html__( 'No movies found', 'extant-demo' ),
			'not_found_in_trash' => esc_html__( 'No movies found in Trash', 'extant-demo' ),
			'parent_item_colon'  => '',
			'menu_name'          => esc_html_x( 'Movies', 'admin menu', 'extant-demo' ),
		);

		$args = array(
			'labels'             => $labels,
			'public'             => true,
			'publicly_queryable' => true,
			'show_ui'            => true,
			'show_in_menu'       => true,
			'menu_icon'          => 'dashicons-movie-alt2',
			'query_var'          => true,
			'rewrite'            => array(
				'slug' => 'movie',
			),
			'capability_type'    => 'post',
			'has_archive'        => 'movies',
			'hierarchical'       => false,
			'menu_position'      => null,
			'supports'           => array(
				'title',
				'editor',
				'excerpt',
				'thumbnail',
				'custom-fields',
			),
			'show_in_rest'       => true,
		);

		register_post_type( 'movie', $args );
	}

	/**
	 * Register the Genres taxonomy for Movies
	 *
	 * @return void
	 */
	public function movies_genre_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Genres', 'taxonomy general name', 'extant-demo' ),
			'singular_name'     => esc_html_x( 'Genre', 'taxonomy singular name', 'extant-demo' ),
			'search_items'      => esc_html__( 'Search Genres', 'extant-demo' ),
			'all_items'         => esc_html__( 'All Genres', 'extant-demo' ),
			'parent_item'       => esc_html__( 'Parent Genre', 'extant-demo' ),
			'parent_item_colon' => esc_html__( 'Parent Genre:', 'extant-demo' ),
			'edit_item'         => esc_html__( 'Edit Genre', 'extant-demo' ),
			'update_item'       => esc_html__( 'Update Genre', 'extant-demo' ),
			'add_new_item'      => esc_html__( 'Add New Genre', 'extant-demo' ),
			'new_item_name'     => esc_html__( 'New Genre Name', 'extant-demo' ),
			'menu_name'         => esc_html__( 'Genres', 'extant-demo' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'movie-genre',
			),
			'show_in_rest'          => true,
		);

		register_taxonomy( 'movie_genre', array( 'movie' ), $args );
	}

	/**
	 * Register Years taxonomy for Movies
	 *
	 * @return void
	 */
	public function movies_year_taxonomy_setup() {
		$labels = array(
			'name'              => esc_html_x( 'Years', 'taxonomy general name', 'extant-demo' ),
			'singular_name'     => esc_html_x( 'Year', 'taxonomy singular name', 'extant-demo' ),
			'search_items'      => esc_html__( 'Search Years', 'extant-demo' ),
			'all_items'         => esc_html__( 'All Years', 'extant-demo' ),
			'parent_item'       => esc_html__( 'Parent Year', 'extant-demo' ),
			'parent_item_colon' => esc_html__( 'Parent Year:', 'extant-demo' ),
			'edit_item'         => esc_html__( 'Edit Year', 'extant-demo' ),
			'update_item'       => esc_html__( 'Update Year', 'extant-demo' ),
			'add_new_item'      => esc_html__( 'Add New Year', 'extant-demo' ),
			'new_item_name'     => esc_html__( 'New Year Name', 'extant-demo' ),
			'menu_name'         => esc_html__( 'Years', 'extant-demo' ),
		);

		$args = array(
			'hierarchical'      => true,
			'labels'            => $labels,
			'show_ui'           => true,
			'show_admin_column' => true,
			'query_var'         => true,
			'rewrite'           => array(
				'slug' => 'movie-year',
			),
			'show_in_rest'          => true,
		);

		register_taxonomy( 'movie_year', array( 'movie' ), $args );
	}

	public function extant_add_movie_meta_boxes() {
		add_meta_box(
			'post_metadata_movie',
			__( 'External Link for this Movie', 'extant-demo' ),
			array( $this, 'extant_movie_meta_box_link' ),
			'movie',
			'advanced',
			'high'
		);
	}

	public function extant_save_movie_meta_boxes( $post_id ){
		
		/*
			* We need to verify this came from the our screen and with proper authorization,
			* because save_post can be triggered at other times.
			*/

		// Check if our nonce is set.
		if ( ! isset( $_POST['extant_movie_inner_custom_box_nonce'] ) ) {
			return $post_id;
		}

		$nonce = $_POST['extant_movie_inner_custom_box_nonce'];

		// Verify that the nonce is valid.
		if ( ! wp_verify_nonce( $nonce, 'extant_movie_inner_custom_box' ) ) {
			return $post_id;
		}

		/*
			* If this is an autosave, our form has not been submitted,
			* so we don't want to do anything.
			*/
		if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
			return $post_id;
		}

		// Check the user's permissions.
		if ( 'page' == $_POST['post_type'] ) {
			if ( ! current_user_can( 'edit_page', $post_id ) ) {
				return $post_id;
			}
		} else {
			if ( ! current_user_can( 'edit_post', $post_id ) ) {
				return $post_id;
			}
		}

		/* OK, it's safe for us to save the data now. */

		// Sanitize the user input.
		$mydata = sanitize_text_field( $_POST['extant_movie_link_new_field'] );

		// Update the meta field.
		update_post_meta( $post_id, 'extant_movie_link_meta_value_key', $mydata );
	}

	
	public function extant_movie_meta_box_link( $post ){
		// Add an nonce field so we can check for it later.
		wp_nonce_field( 'extant_movie_inner_custom_box', 'extant_movie_inner_custom_box_nonce' );

		// Use get_post_meta to retrieve an existing value from the database.
		$value = get_post_meta( $post->ID, 'extant_movie_link_meta_value_key', true );

		// Display the form, using the current value.
		?>
		<label for="extant_movie_link_new_field">
			<?php _e( 'Add external url for this movie. ', 'extant-demo' ); ?>
		</label>
		<input type="text" id="extant_movie_link_new_field" name="extant_movie_link_new_field" value="<?php echo esc_attr( $value ); ?>" size="100" />
		<?php
	}


	public function assets() {
		//wp_enqueue_media();
		// wp_enqueue_script( 'media-upload' );
		// wp_enqueue_script( 'thickbox' );
		// wp_enqueue_style( 'thickbox' );

		// wp_enqueue_script( 'lsx-movie-admin', LSX_TEAM_URL . 'assets/js/lsx-movie-admin.min.js', array( 'jquery' ), LSX_TEAM_VER );
		// wp_enqueue_style( 'lsx-movie-admin', LSX_TEAM_URL . 'assets/css/lsx-movie-admin.css', array(), LSX_TEAM_VER );
	}

}

$extant_demo_movies = new ExtantDemo_Movies();
