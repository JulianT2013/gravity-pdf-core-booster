<?php

namespace GFPDF\Plugins\CoreBooster\Shared;

use GFFormsModel;

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
 * Class ImageInfo
 *
 * @package GFPDF\Plugins\CoreBooster\Shared
 */
class ImageInfo {

	/**
	 * @param string $path
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function get_image_resized_filepath( $path ) {
		$file_info = pathinfo( $path );

		return $file_info['dirname'] . '/' . $file_info['filename'] . '-pdf-resized.' . $file_info['extension'];
	}


	/**
	 * @param string $path
	 *
	 * @return bool
	 *
	 * @since 1.0
	 */
	public function does_file_have_image_extension( $path ) {
		$allowed_extensions = [ 'jpg', 'jpeg', 'gif', 'png' ];

		if ( in_array( strtolower( pathinfo( $path, PATHINFO_EXTENSION ) ), $allowed_extensions ) ) {
			return true;
		}

		return false;
	}

	/**
	 * @param $url
	 *
	 * @return string
	 *
	 * @since 1.0
	 */
	public function get_file_path( $url ) {
		return GFFormsModel::get_physical_file_path( $url );
	}
}