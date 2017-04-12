<?php

namespace GFPDF\Plugins\EnhancedOptionFields;

use GFPDF\Plugins\EnhancedOptionFields\Options\AddOptionsConfiguration;
use GFPDF\Plugins\EnhancedOptionFields\Options\DisplayAllOptions;
use GFPDF\Plugins\EnhancedOptionFields\Options\DisplayLabelOrValue;
use GFPDF\Plugins\EnhancedOptionFields\Styles\AddStyles;
use GFPDF\Helper\Helper_Singleton;

/**
 * Bootstrap Class
 *
 * @package     Gravity PDF Universal Selectors
 * @copyright   Copyright (c) 2017, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       1.0
 */

/* Exit if accessed directly */
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/*
    This file is part of Gravity PDF.

    Gravity PDF – Copyright (C) 2017, Blue Liquid Designs

    This program is free software; you can redistribute it and/or modify
    it under the terms of the GNU General Public License as published by
    the Free Software Foundation; either version 2 of the License, or
    (at your option) any later version.

    This program is distributed in the hope that it will be useful,
    but WITHOUT ANY WARRANTY; without even the implied warranty of
    MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
    GNU General Public License for more details.

    You should have received a copy of the GNU General Public License
    along with this program; if not, write to the Free Software
    Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

/* Load Composer */
require_once( __DIR__ . '/../vendor/autoload.php' );

/**
 * Class Bootstrap
 *
 * @package GFPDF\Plugins\EnhancedOptionFields
 */
class Bootstrap {

	/**
	 * Makes our MVC classes sudo-singletons by allowing easy access to the original objects
	 * through `$singleton->get_class();`
	 *
	 * @var Helper_Singleton
	 *
	 * @since 1.0
	 */
	public $singleton;

	/**
	 * @since 1.0
	 */
	public function init() {
		$this->singleton = new Helper_Singleton();

		/* Get the current PDF template (if any) and check the group is Core or Universal */
		$form_settings = \GPDFAPI::get_mvc_class( 'Model_Form_Settings' );
		$templates     = \GPDFAPI::get_templates_class();

		$classes = [
			new AddOptionsConfiguration( $form_settings, $templates ),
			new DisplayAllOptions(),
			new DisplayLabelOrValue(),
			new AddStyles(),
		];

		/* Initialise our classes and add to our singleton */
		array_walk( $classes, function( $class ) {
			$class->init();
			$this->singleton->add_class( $class );
		} );
	}
}

/* Use the filter below to replace and extend our Bootstrap class if needed */
$plugin = apply_filters( 'gfpdf_enhanced_option_fields_initialise', new Bootstrap() );
$plugin->init();

/* Use the action below to access our Bootstrap class, and any singletons saved in $plugin->singleton */
do_action( 'gfpdf_enhanced_option_fields_init', $plugin );