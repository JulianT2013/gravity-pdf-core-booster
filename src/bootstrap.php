<?php

namespace GFPDF\Plugins\CoreBooster;

use GFPDF\Plugins\CoreBooster\Shared\DoesTemplateHaveGroup;
use GFPDF\Plugins\CoreBooster\EnhancedLabels\Options\AddFields as LabelsAddFields;
use GFPDF\Plugins\CoreBooster\EnhancedLabels\Options\DisplayFieldLabel;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Options\AddFields as OptionsAddFields;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Options\DisplayAllOptions;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Options\DisplayLabelOrValue;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Styles\AddStyles;

use GFPDF\Helper\Licensing\EDD_SL_Plugin_Updater;
use GFPDF\Helper\Helper_Abstract_Licensing;
use GFPDF\Helper\Helper_Singleton;

use GPDFAPI;

/**
 * Bootstrap Class
 *
 * @package     Gravity PDF Core Booster
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
 * @package GFPDF\Plugins\CoreBooster
 */
class Bootstrap extends Helper_Abstract_Licensing {

	/**
	 * @param array $classes
	 *
	 * @since 1.0
	 */
	public function init( $classes = [] ) {
		/* Create new intances of the plugin's classes */
		$group_checker = new DoesTemplateHaveGroup( GPDFAPI::get_mvc_class( 'Model_Form_Settings' ), GPDFAPI::get_templates_class() );

		$classes = array_merge( $classes, [
			new LabelsAddFields( $group_checker ),
			new DisplayFieldLabel(),
			new OptionsAddFields( $group_checker ),
			new DisplayAllOptions(),
			new DisplayLabelOrValue(),
			new AddStyles(),
		] );

		/* Run the setup */
		parent::init( $classes );
	}

	/**
	 * @since 1.0
	 */
	public function plugin_updater() {

		/* Skip over this addon if license status isn't active */
		$license_info = $this->get_license_info();
		if ( $license_info['status'] !== 'active' ) {
			return;
		}

		new EDD_SL_Plugin_Updater(
			$this->data->store_url,
			$this->get_main_plugin_file(),
			[
				'version'   => $this->get_version(),
				'license'   => $license_info['license'],
				'item_name' => $this->get_name(),
				'author'    => $this->get_version(),
				'beta'      => false,
			]
		);
	}
}

/* Use the filter below to replace and extend our Bootstrap class if needed */
$plugin = apply_filters( 'gfpdf_core_booster_initialise', new Bootstrap(
	'gravity-pdf-core-booster',
	'Core Booster Add-On',
	'Gravity PDF',
	GFPDF_CORE_BOOSTER_VERSION,
	GFPDF_CORE_BOOSTER_FILE,
	GPDFAPI::get_data_class(),
	GPDFAPI::get_options_class(),
	new Helper_Singleton()
) );

$plugin->init();

/* Use the action below to access our Bootstrap class, and any singletons saved in $plugin->singleton */
do_action( 'gfpdf_core_booster_bootrapped', $plugin );