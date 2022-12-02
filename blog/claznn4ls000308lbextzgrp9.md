# The Costs Of Legacy Support

PHP has been around for a while. 1995 saw the release of version 1. By 1998, version 3 was released. 2000 saw version 4 released with some limited class support. And then a funny thing happened. PHP took over the web! Currently, about 77% of all websites surveyed use PHP, and while that number is very slowly declining, PHP has shown remarkable staying power. And you can see why. PHP does not dictate a programming style. You can use traditional procedural code, more modern object-oriented code, or even functional style programming, or any mix of the three. And PHP is free and fast enough for who it is for.

As any famous person can tell you, there is no bigger curse than being popular. PHP has its share of haters simply because PHP is very good at what is does, processing text into websites. Modern PHP is a fairly advanced language. PHP 8.1 has come a long way from the early 5.0 object model. With each new version of PHP, we gained better type support and more features to support a best-in-class language for web development.

### Adoption of the latest versions of PHP is slow

As of this writing (November 2022), less than 40% of [Packagist.org](https://packagist.org/php-statistics) requests are on the latest version of PHP (8.1), which is over a year old. Why? Because why mess with success. I have something that works, why should I spend the time to change?

### Here is the problem

Not upgrading costs you [execution speed](https://kinsta.com/blog/php-benchmarks/), loss of [support for bugs](https://www.php.net/releases/index.php), and [new features](https://phpunit.de/supported-versions.html).

If you are a package maintainer, not supporting the latest version of PHP is simply not acceptable. People want to take advantage of new PHP features, and your package not supporting the most recent PHP release means you are preventing others from updating. If you are supporting PHP versions older than PHP actively supports, then you are not encouraging people to upgrade their version of PHP. PHP supports the current version plus the two previous releases. This is a reasonable strategy for PHP, as they want to encourage people to move.

### What is a reasonable strategy for package maintainers?

I would argue you should support either 7.1 and higher, 7.4 and higher, or simply only currently supported versions. PHP 7.1 added return types and was generally recognized as a quick upgrade from PHP 7.0, but 7.2 and 7.3 did not bring much to the table in terms of additional functionality for developers. PHP 7.4 added typed properties which help produce more verifiably correct programs.

And finally, supporting only supported PHP versions seems to be catching on with most major packages. [Symfony](https://packagist.org/php-statistics?query=symfony) seems to just be supporting PHP 8.1 on the latest versions of their packages.

### But what about my legacy users?

When upgrading a package, you always have to consider your users. Making too big of a change between versions can cause a major drop-off in your package's usage. See [Angular](https://angular.io/guide/upgrade) and [Python](https://docs.python.org/3/howto/pyporting.html). But with Packagist and proper PHP versioning in your composer.json file, you already support older versions of PHP. Packagist will resolve the correct version of your library for legacy installs. This frees you to drop support for older PHP versions and use the new language features to make your code better and easier to maintain and verify correctness.

### Pick an upgrade policy and stick with it

You should properly document your PHP upgrade strategy so users know what to expect. Pick a reasonable and well-defined strategy then stick to it. Personally, I only supported versions of PHP with the occasional exception of a new library or dropping the oldest version of PHP when code updates make it too difficult to maintain compatibility. For example, I recently dropped 7.4 support for a few packages after updating them to [PHPStan Level 6](https://phpstan.org/user-guide/rule-levels). It just did not make any sense to not update the code to 8.0 just to support 7.4 for just a few months before 8.2 shipped.

### Be A Leader!

Finally, decide to be a leader and only support modern PHP. As a community contributor, you can help make a difference and move the community forward one package at a time. With 8.2 just around the corner, now is the time to think about upgrading your minimum supported PHP level. I hope I have convinced you to up your game and that of PHP in general.