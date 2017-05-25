RefiefWeb API - PHP Client
==========================

Really simple php client for the ReliefWeb API (v1).

API url
-------

https://api.reliefweb.int/v1

API documentation
-----------------

See the [ReliefWeb API documentation](http://reliefweb.int/help/api).

Install
-------

Run `composer install`.

Usage
-----

See examples below and read functions details in src/RWAPIClient.

Examples
--------

```php
// Include autoloader.
include 'vendor/autoload.php';

// Create a client.
$client = new \RWAPIClient\Client();

// Set the name of the application or website using the API.
$client->appname('example.com');

// Create a query to a resource.
$query = new \RWAPIClient\Query('reports', $client);

// Set the number of document to return.
$query->limit(10);

// Set the fields to include in the results.
$query->fields(array('title', 'theme', 'country', 'source'));

// Set the how the results should be sorted.
$query->sort('date', 'desc');

// Add a query string on the title and body fields.
$query->search('humanitarian', array('title', 'body'));

// Create a conditional filter.
$filter = new \RWAPIClient\Filter();
$filter->condition('date', array('from' => '2013-10-01T00:00:00+00:00'));

// Create a nested filter.
$nested_filter = new \RWAPIClient\Filter('OR');
$nested_filter->condition('theme', array('agriculture', 'health'), 'AND');
$nested_filter->condition('source', array('ocha', 'unhcr'), 'OR');
$filter->filter($nested_filter);

// Add the fitler to the query.
$query->filter($filter);

// Create a facet on countries ordered by name.
$facet = new \RWAPIClient\Facet('country', 'country', 250);
$facet->sort('value', 'asc');

// Add the country facet to the query.
$query->facets($facet);

// Create a facet on sources ordered by count (10 most).
$facet = new \RWAPIClient\Facet('organization', 'source', 10);

// Add the souce facet to the query.
$query->facets($facet);

// Run the query.
$results = $query->execute();

// Display the title of the returned resource items.
$items = $results->items();
foreach ($items as $item) {
  echo $item['fields']['title'] . "\n";
}

// Display the source facet items.
$organizations = $results->facet('organization');
foreach ($organizations['data'] as $organization) {
  echo $organization['value'] . ' - ' . $organization['count'] . "\n";
}
```

To get a single resource item:

```php
// Include autoloader.
include 'vendor/autoload.php';

// Create a client.
$client = new \RWAPIClient\Client();

// Set the name of the application or website using the API.
$client->appname('example.com');

// Create a query to a resource.
$query = new \RWAPIClient\Query('reports', $client);

// Get the resource item (with minimal profile).
$item = $query->id(548925)->profile('minimal')->execute()->item();

// Display the item title.
echo $item['fields']['title'] . "\n";

```
