<?php

namespace GFPDF\Plugins\CoreBooster\EnhancedLabels\Options;

use GFPDF\Helper\Helper_Interface_Actions;

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
 * Class DisplayFieldLabel
 *
 * @package GFPDF\Plugins\CoreBooster\EnhancedLabels\Options
 */
class DisplayFieldLabel implements Helper_Interface_Actions {

	/**
	 * Holds the user selection for the 'field_label_display' setting
	 *
	 * @var string
	 *
	 * @since 1.0
	 */
	protected $label_type;

	/**
	 * Initialise our module
	 *
	 * @since 1.0
	 */
	public function init() {
		$this->add_actions();
	}

	/**
	 * @since 1.0
	 */
	public function add_actions() {
		add_action( 'gfpdf_pre_html_fields', [ $this, 'apply_settings' ], 10, 2 );
		add_action( 'gfpdf_post_html_fields', [ $this, 'reset_settings' ], 10, 2 );
	}

	/**
	 * If the 'field_label_display' setting isn't Standard add filter to change the label format
	 *
	 * @param array $entry
	 * @param array $settings
	 *
	 * @since 1.0
	 */
	public function apply_settings( $entry, $settings ) {
		$settings = $settings['settings'];

		if ( isset( $settings['field_label_display'] ) && $settings['field_label_display'] !== 'Standard' ) {
			$this->label_type = $settings['field_label_display'];
			add_filter( 'gfpdf_field_label', [ $this, 'change_field_label_display' ], 10, 2 );
		}
	}

	/**
	 * Alter the current field label if the 'field_label_display' setting is changed
	 *
	 * @param string $label
	 * @param object $field
	 *
	 * @since 1.0
	 *
	 * @return string
	 */
	public function change_field_label_display( $label, $field ) {
		switch ( $this->label_type ) {
			case 'Admin':
				return $field->adminLabel;
			break;

			case 'Admin Empty':
				return ( strlen( $field->adminLabel ) === 0 ) ? $label : $field->adminLabel;
			break;
		}

		return $label;
	}

	/**
	 * Remove the filter that alters the field label
	 *
	 * @since 1.0
	 */
	public function reset_settings() {
		remove_filter( 'gfpdf_field_label', [ $this, 'change_field_label_display' ] );
	}
}