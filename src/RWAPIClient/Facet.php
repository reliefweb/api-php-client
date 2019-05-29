<?php

namespace RWAPIClient;

use RWAPIClient\Filter as Filter;

/**
 * ReliefWeb API Client Facet.
 */
class Facet {
  /**
   * Internal build.
   *
   * @var array
   */
  protected $build = array();

  /**
   * Build a facet with basic options.
   *
   * @param string $name
   *   Facet name.
   * @param string $field
   *   Field used to compute the facet data.
   * @param int $limit
   *   Maximum number of items to return for the facet.
   */
  public function __construct($name = '', $field = '', $limit = NULL) {
    if (!empty($name)) {
      $this->build['name'] = $name;
    }
    if (!empty($field)) {
      $this->build['field'] = $field;
    }
    if (!empty($limit)) {
      $this->build['limit'] = $limit;
    }
  }

  /**
   * Set the name of the facet.
   *
   * @param string $name
   *   Facet name.
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function name($name) {
    $this->build['name'] = $name;
    return $this;
  }

  /**
   * Set the field of the facet.
   *
   * @param string $field
   *   Facet field.
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function field($field) {
    $this->build['field'] = $field;
    return $this;
  }

  /**
   * Set the limit of the facet.
   *
   * @param string $limit
   *   Facet limit.
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function limit($limit) {
    $this->build['limit'] = $limit;
    return $this;
  }

  /**
   * Set the sort option of the facet.
   *
   * @param string $order
   *   Order type (value or count).
   * @param string $direction
   *   Direction of the ordering (asc or desc).
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function sort($order, $direction) {
    $this->build['sort'] = $order . ':' . $direction;
    return $this;
  }

  /**
   * Set the facet filter.
   *
   * @param \RWAPIClient\Filter $filter
   *   Facet filter.
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function filter(Filter $filter) {
    $this->build['filter'] = $filter->build();
    return $this;
  }

  /**
   * Set the facet scope.
   *
   * @param string $scope
   *   Facet scope.
   *
   * @return \RWAPIClient\Facet
   *   This object.
   */
  public function scope($scope) {
    $this->build['scope'] = $scope;
    return $this;
  }

  /**
   * Return the built API facet data.
   *
   * @return array
   *   API facet data.
   */
  public function build() {
    return $this->build;
  }

}
