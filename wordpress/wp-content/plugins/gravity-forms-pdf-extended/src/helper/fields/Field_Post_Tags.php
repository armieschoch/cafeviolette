<?php

namespace GFPDF\Helper\Fields;

use GFPDF\Helper\Helper_Abstract_Form;
use GFPDF\Helper\Helper_Misc;
use GFPDF\Helper\Helper_Abstract_Fields;

use GF_Field_Post_Tags;

use Exception;

/**
 * Gravity Forms Field
 *
 * @package     Gravity PDF
 * @copyright   Copyright (c) 2017, Blue Liquid Designs
 * @license     http://opensource.org/licenses/gpl-2.0.php GNU Public License
 * @since       4.0
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
 * Controls the display and output of a Gravity Form field
 *
 * @since 4.0
 */
class Field_Post_Tags extends Helper_Abstract_Fields {

	/**
	 * Check the appropriate variables are parsed in send to the parent construct
	 *
	 * @param object                             $field The GF_Field_* Object
	 * @param array                              $entry The Gravity Forms Entry
	 *
	 * @param \GFPDF\Helper\Helper_Abstract_Form $gform
	 * @param \GFPDF\Helper\Helper_Misc          $misc
	 *
	 * @throws Exception
	 *
	 * @since 4.0
	 */
	public function __construct( $field, $entry, Helper_Abstract_Form $gform, Helper_Misc $misc ) {

		if ( ! is_object( $field ) || ! $field instanceof GF_Field_Post_Tags ) {
			throw new Exception( '$field needs to be in instance of GF_Field_Post_Tags' );
		}

		/* call our parent method */
		parent::__construct( $field, $entry, $gform, $misc );
	}

	/**
	 * Standardised method for returning the field's correct $form_data['field'] keys
	 *
	 * @return array
	 *
	 * @since 4.0
	 */
	public function form_data() {

		$value    = implode( ', ', $this->value() );
		$label    = $this->get_label();
		$field_id = (int) $this->field->id;
		$data     = [];

		/* Add HTML output */
		$data[ $field_id . '.' . $label ] = $value;
		$data[ $field_id ]                = $value;
		$data[ $label ]                   = $value;

		return [ 'field' => $data ];
	}

	/**
	 * Display the HTML version of this field
	 *
	 * @param string $value
	 * @param bool   $label
	 *
	 * @return string
	 *
	 * @since 4.0
	 */
	public function html( $value = '', $label = true ) {
		$value = implode( ', ', $this->value() );

		return parent::html( $value );
	}

	/**
	 * Get the standard GF value of this field
	 *
	 * @return string|array
	 *
	 * @since 4.0
	 */
	public function value() {
		if ( $this->has_cache() ) {
			return $this->cache();
		}

		$value = explode( ',', $this->get_value() ); /* get tags and turn into array */
		$value = array_map( 'trim', $value );
		$value = array_map( 'esc_html', $value );

		$this->cache( $value );

		return $this->cache();
	}
}
