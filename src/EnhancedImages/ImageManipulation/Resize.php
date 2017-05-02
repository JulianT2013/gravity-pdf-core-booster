<?php

namespace GFPDF\Plugins\CoreBooster\EnhancedImages\ImageManipulation;

use GFPDF\Plugins\CoreBooster\Shared\ImageInfo;
use GFPDF\Helper\Helper_Interface_Actions;
use abeautifulsite\SimpleImage;

use GFAPI;
use Exception;

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
 * Class Resize
 *
 * @package GFPDF\Plugins\CoreBooster\EnhancedImages\ImageManipulation
 */
class Resize implements Helper_Interface_Actions {

	/**
	 * @var ImageInfo
	 *
	 * @since 1.0
	 */
	protected $image_info;

	/**
	 * Resize constructor.
	 *
	 * @param ImageInfo $image_info
	 *
	 * @since 1.0
	 */
	public function __construct( ImageInfo $image_info ) {
		$this->image_info = $image_info;
	}

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
		add_action( 'gform_entry_post_save', [ $this, 'maybe_resize_images' ], 10, 2 );
		add_action( 'gform_after_update_entry', [ $this, 'maybe_resize_images_after_update' ], 10, 2 );
	}

	/**
	 * @param $entry
	 * @param $form
	 *
	 * @since 1.0
	 */
	public function maybe_resize_images( $entry, $form ) {

		/* Get all file upload fields in the form */
		$upload_fields = array_filter( $form['fields'], function( $field ) {
			return $field->get_input_type() === 'fileupload';
		} );

		/* Resize our images (if any) */
		array_walk( $upload_fields, function( $field ) use ( $entry ) {
			$files = $this->get_upload_files( $field, $entry );

			if ( count( $files ) === 0 ) {
				return;
			}

			$this->handle_image_resize( $files );
		} );
	}

	/**
	 * @param $form
	 * @param $entry_id
	 *
	 * @since 1.0
	 */
	public function maybe_resize_images_after_update( $form, $entry_id ) {
		$entry = GFAPI::get_entry( $entry_id );
		$this->maybe_resize_images( $entry, $form );
	}


	/**
	 * @param array $files
	 *
	 * @since 1.0
	 */
	public function handle_image_resize( $files ) {
		array_walk( $files, function( $file ) {
			$path = $this->image_info->get_file_path( $file );

			/* Check if the image is resized already */
			if ( $this->image_info->does_file_have_image_extension( $path ) &&
			     ! is_file( $this->image_info->get_image_resized_filepath( $path ) )
			) {
				$this->resize_image( $path );
			}
		} );
	}

	/**
	 * @param string $path
	 *
	 * @since 1.0
	 */
	public function resize_image( $path ) {
		$resize_image_path = $this->image_info->get_image_resized_filepath( $path );

		if ( ! is_file( $path ) ) {
			return;
		}

		try {
			( new SimpleImage( $path ) )
				->best_fit( 1000, 1000 )
				->save( $resize_image_path );

			$img = null; /* ensure image is wiped from memory */
		} catch ( Exception $e ) {
			/* Log error */
		}
	}

	/**
	 * @param $field
	 * @param $entry
	 *
	 * @return array
	 *
	 * @since 1.0
	 */
	protected function get_upload_files( $field, $entry ) {
		$files = $entry[ $field->id ];
		$files = ( $field->multipleFiles ) ? (array) json_decode( $files ) : [ $files ];

		return array_filter( $files );
	}
}