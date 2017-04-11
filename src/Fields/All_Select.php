<?php

namespace GFPDF\Plugins\EnhancedOptionFields\Fields;

use GFPDF\Helper\Fields\Field_Select;
use GFPDF\Helper\Helper_Abstract_Fields;

/**
 * Gravity Forms Field
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2016, Blue Liquid Designs
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
 * Controls the display and output of the Checkbox HTML
 *
 * @since 1.0
 */
class All_Select extends Field_Select {

	/**
	 * Include all checkbox options in the list and tick the ones that were selected
	 *
	 * @param string $value
	 * @param bool   $label
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function html( $value = '', $label = true ) {

		$selected_item = $this->value();

		$value         = apply_filters( 'gfpdf_show_field_value', false ); /* Set to `true` to show a field's value instead of the label */

		$html = '<ul class="checked select select-show-all-options">';
		foreach ( $this->field->choices as $key => $option ) {
			$html .= $this->get_option_markup( $option, $key, $selected_item['value'] );
		}

		$html .= '</ul>';

		return Helper_Abstract_Fields::html( $html );
	}

	/**
	 * @param $option
	 * @param $key
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	private function get_option_markup( $option, $key, $selected ) {
		$sanitized_option = ( $value ) ? $option['value'] : $option['text'];
		$checked          = ( $option['value'] === $selected ) ? '&#9746;' : '&#9744;';

		return "<li id='field-{$this->field->id}-option-$key'>
				<span style='font-size: 125%;'>$checked</span> $sanitized_option
				</li>";
	}
}
