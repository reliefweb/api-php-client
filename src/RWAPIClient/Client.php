<?php

namespace RWAPIClient;

use RWAPIClient\Query as Query;

/**
 * ReliefWeb API Client.
 */
class Client {
  /**
   * API URL.
   *
   * @var string
   */
  protected $url;

  /**
   * Application name.
   *
   * @var string
   */
  protected $appname;

  /**
   * Hypermedia switch.
   *
   * @var bool
   */
  protected $hypermedia = FALSE;

  /**
   * Build client.
   *
   * @param string $url
   *   API base url.
   */
  public function __construct($url = 'https://api.reliefweb.int/v1') {
    $this->url = $url;
  }

  /**
   * Set the name of the application or website using the API.
   *
   * @param string $appname
   *   Application name.
   */
  public function appname($appname = "") {
    $this->appname = $appname;
    return $this;
  }

  /**
   * Enable/Disable hypermedia links in the response payload.
   *
   * @param bool $enable
   *   TRUE to enable.
   */
  public function hypermedia($enable = FALSE) {
    $this->hypermedia = $enable;
    return $this;
  }

  /**
   * Query the API.
   *
   * Note: CURL is required.
   *
   * @param string $resource
   *   Resource name.
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   * @param int $method
   *   POST or GET method.
   * @param int $timeout
   *   Request timeout.
   *
   * @return array
   *   Data received by the API or null in case of error.
   */
  public function query($resource, $data = array(), $method = 'POST', $timeout = 2) {
    $url = $this->url . '/' . $resource;

    $parameters = array(
      'appname' => !empty($this->appname) ? $this->appname : 'rw-api-php-client',
    );

    // Return the slim version of the payload without the hypermedia links
    // unless specified otherwise.
    if ($this->hypermedia !== TRUE) {
      $parameters['slim'] = 1;
    }

    // Add the parameters to the url.
    $url .= '?' . http_build_query($parameters, '', '&');

    if ($data instanceof Query) {
      $data = $data->build();
    }

    // Add the GET data to the url.
    if ($method === 'GET') {
      if (is_array($data)) {
        $data = http_build_query($data, '', '&');
      }
      $url .= !empty($data) ? '&' . $data : '';
    }

    $curl = curl_init($url);

    // Add the POST data to the request.
    if ($method === 'POST') {
      if (is_array($data)) {
        $data = json_encode($data);
      }
      $headers = array(
        'Content-Type: application/json',
        'Content-Length: ' . strlen($data),
      );

      curl_setopt($curl, CURLOPT_POSTFIELDS, $data);
      curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
    }

    curl_setopt($curl, CURLOPT_CUSTOMREQUEST, $method);
    curl_setopt($curl, CURLOPT_RETURNTRANSFER, TRUE);
    curl_setopt($curl, CURLOPT_TIMEOUT, $timeout);
    curl_setopt($curl, CURLOPT_CONNECTTIMEOUT, $timeout);
    $result = curl_exec($curl);
    $status = curl_getinfo($curl, CURLINFO_HTTP_CODE);
    curl_close($curl);

    return $status === 200 ? json_decode($result, TRUE) : NULL;
  }

  /**
   * Shortcut to query reports.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function reports($data = array()) {
    return $this->query('reports', $data);
  }

  /**
   * Shortcut to query jobs.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function jobs($data = array()) {
    return $this->query('jobs', $data);
  }

  /**
   * Shortcut to query training.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function training($data = array()) {
    return $this->query('training', $data);
  }

  /**
   * Shortcut to query sources.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function sources($data = array()) {
    return $this->query('sources', $data);
  }

  /**
   * Shortcut to query countries.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function countries($data = array()) {
    return $this->query('countries', $data);
  }

  /**
   * Shortcut to query disasters.
   *
   * @param \RWAPIClient\Query|array $data
   *   Data to pass to the API.
   *
   * @return array
   *   Data received by the API.
   */
  public function disasters($data = array()) {
    return $this->query('disasters', $data);
  }

}
