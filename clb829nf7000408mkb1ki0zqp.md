---
title: "Packagist Best Practices"
datePublished: Sat Dec 03 2022 14:59:50 GMT+0000 (Coordinated Universal Time)
cuid: clb829nf7000408mkb1ki0zqp
slug: packagist-best-practices
cover: https://cdn.hashnode.com/res/hashnode/image/upload/v1670079385265/Av6KR_0EU.png
tags: php, composer, packagist

---

When creating a package for other PHP developers to use, it helps to follow some basic rules to help the developers you are trying to get to use your package. While there are [other guides](https://www.makeuseof.com/learn-how-to-distribute-your-php-packages-with-packagist/) on how to [publish](https://www.w3resource.com/php/composer/create-publish-and-use-your-first-composer-package.php) a package on packagist.org, I thought I would cover some of the unsaid things that lead to better packages.

### Don't check in composer.lock

While you want to check in your lock file for testing and release for your own website, lock files DO NOT belong in a package. If you need a specific version of another package, specify the version in the require section. Composer will handle the rest.

Run "*composer outdated*" regularly to make sure you are not requiring older versions of other packages.

### require-dev

```json
    "require-dev": {
        "phpunit/phpunit": ">=8",
        "roave/security-advisories": "dev-latest",
        "friendsofphp/php-cs-fixer": ">=3.0",
        "phpstan/phpstan": "^1.8"
    }
```

Make sure you do not include test packages or anything else required only for development in the require section, or these packages will be hauled into production. Not good!

### PSR-0 or PSR-4 autoloading only

```json
    "autoload": {
        "psr-4": {"PHPFUI\\": "src/PHPFUI/"}
    },
    "autoload-dev": {
        "psr-4": {"Fixtures\\": "tests/Fixtures/"}
    }
```

It is 2022 already, and you should let Composer handle things for you. There is absolutely no reason to include autoloader.php files or any other file that includes another file to make your package run correctly. You should have NO includes in any source file. This just adds complexity to something Composer handles automatically.

Use PSR-0 or PSR-4 autoloading exclusively. Both work great and will allow proper autoloading. DO NOT use functions, global or otherwise, as these break faster autoloading since they can not be easily loaded as compared to classes. Instead, use static methods in a class. This will autoload correctly and is the same thing as a standalone function. Global functions are bad practice and namespaced functions are just annoying for autoloading and not needed.

Use autoload-dev for PSR autoloading of your tests. Do not list your test files in the normal autoload section, as this will cause your tests to deploy to your user's production.

### Put all source files in the src directory

The src directory should only include the source files that you want in production. DO NOT include test or example code here. Any files that are not PHP source code, but required for operation, should be included here and referenced in the source code with the **\_\_DIR\_\_** PHP macro.

With PSR-0 loading you will have to start from the root namespace in the src directory. PSR-4 allows you to skip deep namespace directories, but which you use is an individual preference.

### Put all tests in the test directory

I tend to name the directory Test to indicate it is in Test namespace, which makes autoloading a bit easier and clearer. Any files needed for testing can be placed in the test directory.

### Put examples in an examples directory

Free free to add subdirectories to the examples directory, but examples should not be in the project root.

### Proper PHP versioning

```json
    "require": {
        "php": ">=7.4 <8.2"
    },
```

Make sure you specify your PHP version correctly. You want to specify a minimum version at a minimum. I personally also specify a maximum version, then update packages when a new version of PHP ships. For example, **\&gt;=7.4 &lt;8.2** is very clear as to what versions of PHP the package supports and prevents subtle issues in the new PHP version from affecting production before the package is fully supported. If you are not going to maintain the package, publish a version without limiting the maximum PHP version to be kind to others.

### GitHub actions

GitHub actions are an excellent way to test your package. Actions can test various configurations of PHP and OSes easily. Here is a nice example of an action testing PHP 7.4 - 8.1 under Windows and Linux:

```yaml
name: Tests

on: [push, pull_request]

jobs:
  php-tests:
    runs-on: ${{ matrix.os }}
    strategy:
      fail-fast: true
      matrix:
        php: [8.1, 8.0, 7.4]
        dependency-version: [prefer-lowest, prefer-stable]
        os: [ubuntu-latest, windows-latest]

    name: ${{ matrix.os }} - PHP${{ matrix.php }} - ${{ matrix.dependency-version }}

    steps:
      - name: Checkout code
        uses: actions/checkout@v3

      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: ${{ matrix.php }}
          extensions: dom, curl, libxml, mbstring, zip, bcmath, intl
          coverage: none

      - name: Install dependencies
        run: |
          composer install --no-interaction
          composer update --${{ matrix.dependency-version }} --prefer-dist --no-interaction --no-suggest

      - name: Execute tests
        run: vendor/bin/phpunit
```

### Code standards

You should have code standards. I find [PHPStan](https://phpstan.org/) does a good job of linting PHP code. Level 6 is a reasonable level to strive for. Go for more if you like.

[PHPCSFixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) is another great tool for formatting code. I run it on git check-in to keep things neat. It has a [great configuration tool here](https://mlocati.github.io/php-cs-fixer-configurator). Highly recommended.

Check any config files from these tools in to the root of your project. This will allow contributors to run the same tests and checks you use.

### Have a Good README.MD

Your **README.MD** file is your primary sales tool. It should have the following sections:

* Overview
    
* Installation if other than **composer require**
    
* Explain the features of your package
    
* Examples
    
* Documentation or links to documentation
    
* Other interesting links
    
* License
    

Assume your users know how to install packages, get to your GitHub repo, and understand dependencies, as Packagist handles all this for you.

### Badges

Badges are a great thing to add to a README.MD, while they don't show up on Packagist, they do on GitHub and can give users a better idea of what the package supports. Here are some example badges:

```markdown
[![Tests](https://github.com/phpfui/phpfui/actions/workflows/tests.yml/badge.svg)](https://github.com/phpfui/phpfui/actions?query=workflow%3Atests)

[![Latest Packagist release](https://img.shields.io/packagist/v/phpfui/phpfui.svg)](https://packagist.org/packages/phpfui/phpfui)

![](https://img.shields.io/badge/PHPStan-level%206-brightgreen.svg?style=flat)
```

### License and other status files

Make sure you include a license file and add the license to the composer.json file. This helps document your intent and adding it to composer.json makes it super easy for license reporting for your users.

Try this command just for fun: **composer license**

Other files you may want to include are codes of conduct, code style (if not automated with PHPCSFixer), Pull Request guidelines and other administrative files that are not directly related to the code. These files should be at the root of the project for easy viewing.

### Full docs

One of the sore points of Open Source is the lack of documentation. Any docs for the code, and not the above administrative files, should be in a docs directory. This will direct developers to the important files. Use file names that describe what the documentation is about. You can also number them to show them in a specific order. All of this helps others and bots to find your documentation and present it to developers.

Automated docs are even better! I wrote [InstaDoc](http://www.phpfui.com/?n=PHPFUI%5CInstaDoc) for exactly this reason. There is no reason not to fully document your PHP code and display the docs if you can host a website someplace.

### .gitignore

```plaintext
.bash_history
.idea/
.php-cs-fixer.cache
.phpintel
.viminfo
.DS_Store
phpunit.html
psalmCommitErrors.txt
tmp/
/vendor/
```

Make sure your .gitignore file is up to date! You should be able to run all tests, code cleanup, linting or other automated tools and not leave unstaged files in git. You should also exclude any files your editor or operating system includes (looking at you .DS\_Store)

Often new versions of dev tools create new cache file names, so check periodically to make sure things are not missed.