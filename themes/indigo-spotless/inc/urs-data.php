<?php
/**
 * Wrappers for urs_data...() functions
 */

function aecom_data_get() {
  if ( ! function_exists( 'urs_data_get' ) ) {
    return;
  }
  $args = func_get_args();
  return call_user_func_array( 'urs_data_get', $args );
}

function aecom_data_set() {
  if ( ! function_exists( 'urs_data_set' ) ) {
    return;
  }
  $args = func_get_args();
  return call_user_func_array( 'urs_data_set', $args );
}

function aecom_data_get_option( $option, $default = false ) {
  if ( ! function_exists( 'urs_data_get_option' ) ) {
    return get_option( $option, $default );
  }
  $args = func_get_args();
  return call_user_func_array( 'urs_data_get_option', $args );
}

function aecom_data_get_site_option( $option, $default = false ) {
  if ( ! function_exists( 'urs_data_get_site_option' ) ) {
    return get_site_option( $option, $default );
  }
  $args = func_get_args();
  return call_user_func_array( 'urs_data_get_site_option', $args );
}

function aecom_get_projects_grouped($site_id = null){
  if ( function_exists( 'urs_get_projects_grouped' ) ) {
    return urs_get_projects_grouped( $site_id );
  }

  return false;
}

function aecom_get_projects_by_tag( $tag ){
  if ( function_exists( 'urs_get_projects_by_tag' ) ) {
    return urs_get_projects_by_tag( $tag );
  }

  return false;
}