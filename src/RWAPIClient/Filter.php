<?php

namespace RWAPIClient;

use RWAPIClient\Filter as Filter;

/**
 * ReliefWeb API Client Filter.
 */
class Filter {
  /**
   * Internal build.
   *
   * @var array
   */
  protected $build = array();

  /**
   * Create the filter with the default operator.
   *
   * @param string $operator
   *   Filter operator in case of multiple conditions.
   * @param bool $negate
   *   Indicates if the filter should be used a NOT filter.
   */
  public function __construct($operator = 'AND', $negate = FALSE) {
    $this->build['conditions'] = array();
    $this->operator($operator);
    $this->negate($negate);
  }

  /**
   * Add a condition to the filter.
   *
   * @param string $field
   *   Field name on ehich to apply the condition.
   * @param array|scalar $value
   *   Single value or array of values
   *   or range array with 'from' and/or 'to' keys.
   * @param string $operator
   *   Operator in case of multiple values.
   * @param bool $negate
   *   Indicates if the filter should be inclusive or exclusive (NOT).
   *
   * @return \RWAPIClient\Filter
   *   This object.
   */
  public function condition($field, $value = NULL, $operator = 'AND', $negate = FALSE) {
    $filter = array('field' => $field);

    if (!empty($operator) && is_array($value) && isset($value[0])) {
      $filter['operator'] = $operator;
    }
    if (!empty($negate)) {
      $filter['negate'] = $negate;
    }
    if (!empty($value)) {
      $filter['value'] = $value;
    }
    $this->build['conditions'][] = $filter;

    return $this;
  }

  /**
   * Add a nested filter contidition.
   *
   * @param \RWAPIClient\Filter $filter
   *   Filter condition.
   *
   * @return \RWAPIClient\Filter
   *   This object.
   */
  public function filter(Filter $filter) {
    $this->build['conditions'][] = $filter->build();
    return $this;
  }

  /**
   * Set the operator in case of multiple conditions.
   *
   * @param string $operator
   *   Filter operator.
   *
   * @return \RWAPIClient\Filter
   *   This object.
   */
  public function operator($operator = 'AND') {
    $this->build['operator'] = $operator;
    return $this;
  }

  /**
   * Set the negation of the filter.
   *
   * @param bool $negate
   *   Indicates if the filter should be inclusive or exclusive (NOT).
   *
   * @return \RWAPIClient\Filter
   *   This object.
   */
  public function negate($negate = FALSE) {
    if (!empty($negate)) {
      $this->build['negate'] = TRUE;
    }
    return $this;
  }

  /**
   * Return the built API facet data.
   *
   * @return array
   *   API filter data.
   */
  public function build() {
    // If only 1 condition, return it as the filter.
    if (count($this->build['conditions']) === 1) {
      return $this->build['conditions'][0];
    }
    return $this->build;
  }

}
