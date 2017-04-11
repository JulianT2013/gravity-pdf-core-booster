<?php

/**
 * Plugin Name:     Gravity PDF Enhanced Option Fields
 * Plugin URI:      https://gravitypdf.com/shop/gravity-pdf-enhanced-option-fields/
 * Description:     PLUGIN DESCRIPTION HERE
 * Author:          Gravity PDF
 * Author URI:      https://gravitypdf.com
 * Text Domain:     gravity-pdf-enhanced-option-fields
 * Domain Path:     /languages
 * Version:         0.1.0
 */

/**
 * Class GPDF_Universal_Selector_Checks
 *
 * @since 1.0
 */
class GPDF_Enhanced_Option_Fields_Checks {

	/**
	 * Holds any blocker error messages stopping plugin running
	 *
	 * @var array
	 *
	 * @since 1.0
	 */
	private $notices = [];

	/**
	 * @var string
     *
     * @since 1.0
	 */
	private $required_gravitypdf_version = '4.1.1';

	/**
	 * @return null
     *
     * @since 1.0
	 */
	public function init() {

		/* Test the minimum version requirements are met */
		$this->check_gravitypdf_version();

		/* Check if any errors were thrown, enqueue them and exit early */
		if ( sizeof( $this->notices ) > 0 ) {
			add_action( 'admin_notices', array( $this, 'display_notices' ) );

			return null;
		}

		require_once __DIR__ . '/src/bootstrap.php';
	}

	/**
	 * @return bool
     *
     * @since 1.0
	 */
	public function check_gravitypdf_version() {

		/* Check if the Gravity PDF Minimum version requirements are met */
		if ( defined( 'PDF_EXTENDED_VERSION' ) &&
		     version_compare( PDF_EXTENDED_VERSION, $this->required_gravitypdf_version, '>=' )
		) {
			return true;
		}

		/* Throw error */
		$this->notices[] = sprintf( esc_html__( 'Gravity PDF Version %s or higher is required to use this add-on. Please upgrade Gravity PDF to the latest version.', 'gravity-pdf-universal-selectors' ), $this->required_gravitypdf_version );
	}

	/**
	 * Helper function to easily display error messages
	 *
	 * @return void
	 *
	 * @since 1.0
	 */
	public function display_notices() {
		?>
        <div class="error">
            <p>
                <strong><?php esc_html_e( 'Gravity PDF Universal Selectors Installation Problem', 'gravity-pdf-universal-selectors' ); ?></strong>
            </p>

            <p><?php esc_html_e( 'The minimum requirements for the Gravity PDF Universal Selectors plugin have not been met. Please fix the issue(s) below to continue:', 'gravity-pdf-universal-selectors' ); ?></p>
            <ul style="padding-bottom: 0.5em">
				<?php foreach ( $this->notices as $notice ) : ?>
                    <li style="padding-left: 20px;list-style: inside"><?php echo $notice; ?></li>
				<?php endforeach; ?>
            </ul>
        </div>
		<?php
	}
}

/* Initialise the software */
$gravitypdf_enhanced_option_fields = new GPDF_Enhanced_Option_Fields_Checks();
add_action( 'gfpdf_fully_loaded', array( $gravitypdf_enhanced_option_fields, 'init' ) );