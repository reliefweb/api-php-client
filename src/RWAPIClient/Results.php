<?php

namespace RWAPIClient;

/**
 * ReliefWeb API Client Results.
 */
class Results {
  /**
   * Raw API data.
   *
   * @var array
   */
  protected $data = array();

  /**
   * Build a results handler.
   *
   * @param array $data
   *   Raw data from the API.
   */
  public function __construct($data) {
    $this->data = $data;
  }

  /**
   * Check if the data is valid.
   *
   * @return boolean
   *   Data is valid or not.
   */
  public function error() {
    return !isset($this->data);
  }

  /**
   * Get the total of resource items matching the query.
   *
   * @return integer
   *   Total.
   */
  public function total() {
    return !empty($this->data['totalCount']) ? $this->data['totalCount'] : 0;
  }

  /**
   * Get the total of resource items returned by the query.
   *
   * @return integer
   *   Count.
   */
  public function count() {
    return !empty($this->data['count']) ? $this->data['count'] : 0;
  }

  /**
   * Get the resource items returned by the query.
   *
   * @return array
   *   List of resource items returned by the query.
   */
  public function items() {
    return !empty($this->data['data']) ? $this->data['data'] : array();
  }

  /**
   * Get the resource item returned by the query.
   * Useful when querying for a single item.
   *
   * @return array
   *   First item returned by the query.
   */
  public function item() {
    return !empty($this->data['data']) ? reset($this->data['data']) : array();
  }

  /**
   * Get the facets.
   *
   * @return array
   *   Facets keyed by name.
   */
  public function facets() {
    return !empty($this->data['embedded']['facets']) ? $this->data['embedded']['facets'] : array();
  }

  /**
   * Get a facet.
   *
   * @return array
   *   Facet data.
   */
  public function facet($name) {
    return !empty($this->data['embedded']['facets'][$name]) ? $this->data['embedded']['facets'][$name] : array();
  }

  /**
   * Get the raw data, NULL is case of query error.
   *
   * @return array
   *   Raw data.
   */
  public function raw() {
    return $this->data;
  }
}
