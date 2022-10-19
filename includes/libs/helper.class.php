<?php


namespace Books;


class Helper {
	/**
	 * @param $name
	 * @param bool $type
	 * @param bool $sanitize
	 *
	 * @return bool|mixed
	 */
	static public function get_var( $name, $type = false, $sanitize = false ) {
		$result = false;

		if( !$type ){
			$result = isset( $_GET[ $name ] ) || isset( $_POST[ $name ] ) ? $_REQUEST[ $name ] : false;
		}

		$isset = 'POST' == $type ? isset( $_POST[ $name ] ) : isset( $_GET[ $name ] );
		if( $isset ){
			$result = $_REQUEST[ $name ];
		}

		if( $sanitize ){
			$result = call_user_func( $sanitize, $result );
		}

		return $result;
	}

	/**
	 * Display select box
	 *
	 * @param array $args - see $defaults in function
	 * @param bool  $echo
	 *
	 * @return string
	 */
	function select( $args = [], $echo = true ){

		$defaults =[
			'options' 	=> [],
			'name'		=> false,
			'id'		=> false,
			'class'		=> '',
			'selected'	=> false,
			'use_keys'	=> true,
			'before'	=> '',
			'after'		=> ''
		];

		$o = wp_parse_args( $args, $defaults );

		if( !$o['id'] ){
			$output = sprintf( '<select name="%1$s" id="%1$s" class="%2$s">', $o['name'], $o['class']);
		}else{
			$output = sprintf( '<select name="%1$s" id="%2$s" class="%3$s">', $o['name'], $o['id'], $o['class']);
		}

		foreach( $o['options'] as $val => $text ){
			$opt = '<option value="%1$s" title="%4$s"%2$s>%3$s</option>';

			if( is_array( $text ) ){
				$title = $text['title'];
				$text = $text['text'];
			}else{
				$title = '';
			}

			$value = $o['use_keys'] ? $val : $text;
			$c = $o['use_keys'] ? $val == $o['selected'] : $text == $o['selected'];
			$checked = $c ? ' selected="selected"' : '';
			$output .= sprintf($opt, $value, $checked, $text, $title);
		}

		$output .= '</select>';

		if( $echo ){
			echo $o['before'].$output.$o['after'];
		}

		return $o['before'].$output.$o['after'];
	}
}