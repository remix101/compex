<?php

class FrontTest extends TestCase {

	/**
	 * Home test.
	 *
	 * @return void
	 */
	public function testHome()
	{
		$crawler = $this->client->request('GET', '/');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * Category test.
	 *
	 * @return void
	 */
	public function testCategory()
	{
		$crawler = $this->client->request('GET', '/listings/categories/1');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * Search test.
	 *
	 * @return void
	 */
	public function testSearch()
	{
		$crawler = $this->client->request('GET', '/search?q=lol');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * Countries test.
	 *
	 * @return void
	 */
	public function testCountries()
	{
		$crawler = $this->client->request('GET', '/listings/countries/36');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

	/**
	 * Listing test.
	 *
	 * @return void
	 */
	public function testListing()
	{
		$crawler = $this->client->request('GET', '/listings/1');

		$this->assertTrue($this->client->getResponse()->isOk());
	}

}
