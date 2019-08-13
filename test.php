<?php

error_reporting(E_ALL);
ini_set("display_errors", 1);

function reliefweb_api_library_autoload($classname) {
  // ReliefWeb API libraries keyed by base namespace.
  $libraries = array(
    'RWAPIIndexer' => 'api-indexer',
    'RWAPIClient' => 'api-php-client',
  );

  // Remove the leading backslash.
  $classname = ltrim($classname, '\\');

  // Extract the root namespace and check if it matches
  // one of the API libraries.
  $base = strstr($classname, '\\', TRUE);
  if (isset($libraries[$base])) {
    // Attempt to include the class file.
    include_once 'src/' . str_replace('\\', DIRECTORY_SEPARATOR, $classname) . '.php';
  }
}

// Register ReliefWeb API libraries autoloader.
spl_autoload_register('reliefweb_api_library_autoload');

// Create a client.
$client = new \RWAPIClient\Client();

// Set the name of the application or website using the API.
$client->appname('example.com')->hypermedia(TRUE);

// Create a query to a resource.
$query = new \RWAPIClient\Query('reports', $client);

// Get the resource item (with minimal profile).
$item = $query->id(548925)->profile('minimal')->execute()->raw();

// Display the item title.
echo print_r($item, TRUE) . "\n";
