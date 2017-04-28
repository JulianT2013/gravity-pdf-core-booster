<?php

namespace GFPDF\Plugins\CoreBooster\EnhancedOptions\Options;

use GFPDF\Helper\Helper_Interface_Filters;
use GFPDF\Helper\Helper_Templates;
use GFPDF\Model\Model_Form_Settings;

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
 * Class ShowAllOptions
 *
 * @package GFPDF\Plugins\CoreBooster\Options
 */
class AddOptionsConfiguration implements Helper_Interface_Filters {

	private $form_settings;
	private $templates;

	/**
	 * AddOptionsConfiguration constructor.
	 *
	 * @param Model_Form_Settings $form_settings
	 * @param Helper_Templates    $templates
	 *
	 * @since 1.0
	 */
	public function __construct( Model_Form_Settings $form_settings, Helper_Templates $templates ) {
		$this->form_settings = $form_settings;
		$this->templates     = $templates;
	}

	/**
	 * @since 1.0
	 */
	public function init() {
		$this->add_filters();
	}

	/**
	 * @since 1.0
	 */
	public function add_filters() {
		add_filter( 'gfpdf_form_settings_custom_appearance', [ $this, 'add_template_option' ], 9999 );
	}

	/**
	 * @param array $settings
	 *
	 * @return array
	 *
	 * @since 1.0
	 */
	public function add_template_option( $settings ) {

		$override = apply_filters( 'gfpdf_override_template_options', false, $settings ); /* Change this to true to override the core / universal check */

		if ( $override || $this->is_template_core_or_universal() ) {
			$settings['show_all_options'] = [
				'id'      => 'show_all_options',
				'name'    => esc_html__( 'Show Field Options', 'gravity-pdf-core-booster' ),
				'type'    => 'multicheck',
				'options' => [
					'Radio'       => esc_html__( 'Show all options for Radio Fields', 'gravity-pdf-core-booster' ),
					'Checkbox'    => esc_html__( 'Show all options for Checkbox Fields', 'gravity-pdf-core-booster' ),
					'Select'      => esc_html__( 'Show all options for Select Fields', 'gravity-pdf-core-booster' ),
					'Multiselect' => esc_html__( 'Show all options for Multiselect Fields', 'gravity-pdf-core-booster' ),
				],
				'tooltip' => '<h6>' . esc_html__( 'Help', 'gravity-forms-pdf-extended' ) . '</h6>' . sprintf( esc_html__( '', 'gravity-pdf-core-booster' ) ),
			];

			$settings['option_label_or_value'] = [
				'id'      => 'option_label_or_value',
				'name'    => esc_html__( 'Option Field Display', 'gravity-pdf-core-booster' ),
				'type'    => 'radio',
				'options' => [
					'Label' => esc_html__( 'Show Label', 'gravity-pdf-core-booster' ),
					'Value' => esc_html__( 'Show Value', 'gravity-pdf-core-booster' ),
				],
				'std'     => 'Label',
				'tooltip' => '<h6>' . esc_html__( 'Help', 'gravity-forms-pdf-extended' ) . '</h6>' . sprintf( esc_html__( '', 'gravity-pdf-core-booster' ) ),
			];
		}

		return $settings;
	}

	/**
	 * @return bool
	 *
	 * @since 1.0
	 */
	private function is_template_core_or_universal() {

		$template_name = $this->form_settings->get_template_name_from_current_page();
		$template_info = $this->templates->get_template_info_by_id( $template_name );

		if ( $template_info['group'] === 'Core' || $template_info['group'] === 'Universal' ) {
			return true;
		}

		return false;
	}
}
