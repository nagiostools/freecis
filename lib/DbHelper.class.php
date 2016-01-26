<?php

class DbHelper 
{

	// Define some useful variables
	private $db;	// DB handle

	/**
	 * Constructor
	 */
	public function __construct( $db )
	{
		$this->setDb( $db );
	} // EOM __construct()


	/* GETTERS & SETTERS */

	/**
	 * setDb()
	 */
	private function setDb( $db )
	{
		$this->db = $db;
	}

	/**
	 * getDb()
	 */
	private function getDb()
	{
		return $this->db;
	}

	/**
	 * Get a list of categories
	 *
	 * Retrieves a list of categories from the database, filter out only
	 * the categories whose active status is set to Yes.
	 *
	 * $return array
	 */
	public function getCategories()
	{
		// Get a list of categories
		$qCategory = "SELECT id, parent_id, catid, category, description, entry_created, entry_modified FROM categories ORDER BY category";
		$qCategoryRes = $this->getDb()->query( $qCategory );

		while ( $catRes = $qCategoryRes->fetchObject() ) {
			$categories[] = $catRes;
		}

		return $categories;
	} // EOM getCategories()


	/**
	 * Get a list of products
	 *
	 * Retrieves a list of products
	 *
	 * $return array
	 */
	public function getProducts()
	{
		// Get a list of products 
		$qProducts = "SELECT productno, description, qty, location, created, updated FROM products ORDER BY productno";
		$qProductsRes = $this->getDb()->query( $qProducts );

		while ( $prodRes = $qProductsRes->fetchObject() ) {
			$products[] = $prodRes;
		}

		return $products;
	} // EOM getProducts()


	/**
	 * 
	 */
	public function getDepartments()
	{
		// Get a list of departments
		$query = "SELECT dep_id AS id, dep_name AS department FROM aq_department WHERE active = 'Yes' ORDER BY dep_name";
		$qRes = $this->getDb()->query( $query );

		while ( $result = $qRes->fetchObject() ) {
			$departments[] = $result;
		}

		return $departments;
	} // EOM getDepartments()
	
	/**
	 * 
	 */
	public function getClients()
	{
		// Get a list of clients 
		$query = "SELECT cid AS id, client FROM clients WHERE active = 'Yes' ORDER BY client";
		$qRes = $this->getDb()->query( $query );

		while ( $result = $qRes->fetchObject() ) {
			$clients[] = $result;
		}

		return $clients;
	} // EOM getClients()
} // EOC DbHelper

