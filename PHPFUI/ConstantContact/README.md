# ConstantContact [![Build Status](https://travis-ci.org/phpfui/phpfui.png?branch=master)](https://travis-ci.org/phpfui/phpfui) [![Latest Packagist release](https://img.shields.io/packagist/v/phpfui/phpfui.svg)](https://packagist.org/packages/phpfui/phpfui)

PHP Object Oriented wrapper for the Constant Contact API

**PHPFUI/ConstantContact** is a [modern](#php-versions) PHP library that tracks the latest changes to the Constant Contact API.

**PHPFUI/ConstantContact** reads the [YAML](https://api.cc.email/v3/swagger.yaml) file from the Constant Contact documentation and generates PHP classes directly from the YAML file. The library is auto updated nightly. This means the library is always up to date with the latest changes. See the [versioning](#Versioning) section for further details.

## Namespaces
This library normalizes the [Constant Contact API](https://v3.developer.constantcontact.com/api_guide/index.html) to modern PHP class standards.  All endpoints are first character capitialized. Underscores are removed and followed by a capital letter. Each end point is a class with methods matching the standard REST methods (ie. put, post, delete, put, etc.).  The methods take required and optional parameters matching the name specified in the Constant Contact YAML API.  In addition, this library supports all definitions of types in the API.  See below.

Due to a mistake in naming conventions by Constant Contact API designers, several end points are duplicated between the end point that returns all objects, and the end point that just updates one object. Normally this is dealt with by using the singular form of the noun for CRUD type operations on a single object, and the plural noun form returns a list of objects. This library follows the correct naming convention (single nouns for CRUD and plural nouns for collections) and not the Constant Contact naming convention.

## Definitions
The Constant Contact API defines all types of objects to interact with the API. All are defined in the Definition namespace. Only valid fields are allowed to be accessed. The type is fully validated as to the best ability of PHP.  Also min and max lengths are enforced for strings. Definitions should be passed to the

## Usage
```PHP
$client = new \PHPFUI\ConstantContact\Client($clientAPIKey, $clientSecret);
$listEndPoint = new \PHPFUI\ConstantContact\V3\ContactLists($client);
$lists = $listEndPoint->get();
print_r($lists);
```

## Versioning
Since the [Constant Contact API](https://v3.developer.constantcontact.com/api_guide/index.html) is constantly being updated, this library will track all updates on a calendar based versioning schema. The major version will be the last two digits of the year the update was released. The minor version will be the month it was released. Any bug fixes will be a patch version.  So V21.8.0 would be the first August 2021 version, and V21.8.1 would be a bug fix to V21.8.  All bug fixes will be included in subsequent versions, so V21.9.0 would include all fixes from the V21.8 version. Yaml changes are tracked nightly and a new version will be generated automatically.

## Documentation
Via [PHPFUI/InstaDoc](http://phpfui.com/?PHPFUI\ConstantContact)

## License
**PHPFUI/ConstantContact** is distributed under the MIT License.

### PHP Versions
This library only supports PHP 8.0 and higher versions of PHP. While we would love to support PHP from the late Ming Dynasty, the advantages of modern PHP versions far out weigh quaint notions of backward compatibility. Time to upgrade.
