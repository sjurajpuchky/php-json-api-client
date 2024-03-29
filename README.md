# php-json-api-client

Simple PHP JSON Rest API Client

# Install

composer require baba/json-api-client

# Example
```PHP
  use BABA\JSON\API\Client\DataProvider\CURL;
  use BABA\JSON\API\Client\JsonRestApiClient;
  
  $client = new JsonRestApiClient(new CURL());
  var_dump($client->get('http://api.example.com/test.json')); 
```

# Supports

- CURL as Data provider

# License

GPL-2.0-only

# Authors

Juraj Puchký - BABA Tumise s.r.o. <info@baba.bj>

https://www.seoihned.cz - SEO optilamizace

https://www.baba.bj - Tvorba webových stránek

https://www.webtrace.cz - Tvorba portálů a ecommerce b2b/b2c (eshopů) na zakázku

# Log

1.0.0 - CURL Implemented

1.0.1 - PATCH Implemented

1.0.2 - HEADER GET (HEAD) Implemented

1.0.3 - RETURN HEADERS on GET Optionally

1.0.4 - MINOR FIXES, ADDED VERBOSE SUPPORT

# Copyright

&copy; 2021 BABA Tumise s.r.o.
