<?php

require_once 'Connector.php';

/**
 * ActiveCampgin Group class
 *
 * @since 2.0.3
 * 
 * @package Optin_Monster
 * @author Garry Gonzales
 */
class AC_Group extends AC_Connector {

	/**
	 * Version
	 *
	 * @since 2.0.3
	 *
	 * @var string
	 */
	public $version;

	/**
	 * Base URL
	 *
	 * @since 2.0.3
	 *
	 * @var string
	 */
	public $url_base;

	/**
	 * URL
	 *
	 * @since 2.0.3
	 *
	 * @var string
	 */
	public $url;

	/**
	 * API Key
	 *
	 * @since 2.0.3
	 *
	 * @var string
	 */
	public $api_key;

	/**
	 * JSON Output
	 *
	 * @since 2.0.3
	 *
	 * @var string
	 */
	public $output = "serialize";

	/**
	 * Primary class constructor
	 *
	 * @since 2.0.3
	 *
	 * @param string @version   Version for ActiveCampaign
	 * @param string @url_base 	Base URL
	 * @param string @url 		URL
	 * @param string @api_key 	API Key
	 */
	public function __construct($version, $url_base, $url, $api_key) {
		$this->version = $version;
		$this->url_base = $url_base;
		$this->url = $url;
		$this->api_key = $api_key;
	}

	/**
	 * Add Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 * @param array @post_data data to be added
	 *
	 * @return array @response response from the server
	 */	
	public function add($params, $post_data) {
		$request_url = "{$this->url}&api_action=group_add&api_output={$this->output}";
		$response = parent::curl($request_url, $post_data);
		return $response;
	}

	/**
	 * Delete List Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 *
	 * @return array @response response from the server
	 */	
	public function delete_list($params) {
		$request_url = "{$this->url}&api_action=group_delete_list&api_output={$this->output}&{$params}";
		$response = parent::curl($request_url);
		return $response;
	}

	/**
	 * Delete Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 *
	 * @return array @response response from the server
	 */	
	public function delete($params) {
		$request_url = "{$this->url}&api_action=group_delete&api_output={$this->output}&{$params}";
		$response = parent::curl($request_url);
		return $response;
	}

	/**
	 * Edit Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 * @param array @post_data data to be edited
	 *
	 * @return array @response response from the server
	 */	
	public function edit($params, $post_data) {
		$request_url = "{$this->url}&api_action=group_edit&api_output={$this->output}";
		$response = parent::curl($request_url, $post_data);
		return $response;
	}

	/**
	 * List Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 *
	 * @return array @response response from the server
	 */	
	public function list_($params) {
		$request_url = "{$this->url}&api_action=group_list&api_output={$this->output}&{$params}";
		$response = parent::curl($request_url);
		return $response;
	}

	/**
	 * View Method for ActiveCampaign group
	 *
	 * @since 2.0.3
	 *
	 * @param array @params paramters for the method
	 *
	 * @return array @response response from the server
	 */	
	public function view($params) {
		$request_url = "{$this->url}&api_action=group_view&api_output={$this->output}&{$params}";
		$response = parent::curl($request_url);
		return $response;
	}

}

?>