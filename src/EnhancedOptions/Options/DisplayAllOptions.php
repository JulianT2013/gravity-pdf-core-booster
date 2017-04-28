<?php

namespace GFPDF\Plugins\CoreBooster\EnhancedOptions\Options;

use GFPDF\Helper\Helper_Abstract_Fields;
use GFPDF\Helper\Helper_Interface_Actions;
use GFPDF\Helper\Helper_Interface_Filters;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Fields\AllCheckbox;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Fields\AllMultiselect;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Fields\AllRadio;
use GFPDF\Plugins\CoreBooster\EnhancedOptions\Fields\AllSelect;

use GPDFAPI;

/**
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

/**
 * Class DisplayAllOptions
 *
 * @package GFPDF\Plugins\CoreBooster\Options
 */
class DisplayAllOptions implements Helper_Interface_Actions, Helper_Interface_Filters {

	private $settings;

	/**
	 * @since 1.0
	 */
	public function init() {
		$this->add_actions();
		$this->add_filters();
	}

	/**
	 * @since 1.0
	 */
	public function add_actions() {
		add_action( 'gfpdf_pre_html_fields', [ $this, 'save_settings' ], 10, 2 );
		add_action( 'gfpdf_post_html_fields', [ $this, 'reset_settings' ], 10, 2 );
	}

	/**
	 * @since 1.0
	 */
	public function add_filters() {
		add_filter( 'gfpdf_field_class', [ $this, 'maybe_autoload_class' ], 10, 3 );
	}

	/**
	 * @param array $entry
	 * @param array $settings
	 *
	 * @since 1.0
	 */
	public function save_settings( $entry, $settings ) {
		$this->settings = $settings['settings'];
	}

	/**
	 * @return array
	 *
	 * @since 1.0
	 */
	public function get_settings() {
		return $this->settings;
	}

	/**
	 * @since 1.0
	 */
	public function reset_settings() {
		$this->settings = null;
	}

	/**
	 * @param Helper_Abstract_Fields $class
	 * @param object                 $field
	 * @param array                  $entry
	 *
	 * @return Helper_Abstract_Fields
	 *
	 * @since 1.0
	 */
	public function maybe_autoload_class( $class, $field, $entry ) {

		/* Ensure the settings have been set and we aren't too early in the process */
		if ( isset( $this->settings['show_all_options'] ) && is_array( $this->settings['show_all_options'] ) ) {
			$option_config = $this->settings['show_all_options'];

			if ( $field->type === 'radio' && isset( $option_config['Radio'] ) ) {
				return new AllRadio( $field, $entry, GPDFAPI::get_form_class(), GPDFAPI::get_misc_class() );
			}

			if ( $field->type === 'select' && isset( $option_config['Select'] ) ) {
				return new AllSelect( $field, $entry, GPDFAPI::get_form_class(), GPDFAPI::get_misc_class() );
			}

			if ( $field->type === 'checkbox' && isset( $option_config['Checkbox'] ) ) {
				return new AllCheckbox( $field, $entry, GPDFAPI::get_form_class(), GPDFAPI::get_misc_class() );
			}

			if ( $field->type === 'multiselect' && isset( $option_config['Multiselect'] ) ) {
				return new AllMultiselect( $field, $entry, GPDFAPI::get_form_class(), GPDFAPI::get_misc_class() );
			}
		}

		return $class;
	}
}