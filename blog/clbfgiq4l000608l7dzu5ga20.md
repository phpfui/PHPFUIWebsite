# PHP 8.2 Release Day!

PHP 8.2 was officially released today (December 8th, 2022), and that means it is time to upgrade!

You don't have to wait till a new version of PHP is officially released. You can find prerelease versions on [php.net](https://www.php.net/) if you look around, but things are easier if it has been officially released.

## Upgrading to PHP 8.2

### Don't use any new PHP 8.2 features just yet!

While we might all be eager to start using the latest PHP features, there is a lot of work to do before you can start using [readonly classes](https://www.php.net/releases/8.2/en.php)!

### Upgrade your local machine first

With any new PHP version, you should make sure your code works with it locally before you think about using it anywhere else.

### Confirm your installation is correct

Type php -v at a command line (assuming it is pathed correctly) and it should return something like:

PHP 8.2.0 (cli) (built: Dec 6 2022 15:31:23) (ZTS Visual C++ 2019 x64) Copyright (c) The PHP Group Zend Engine v4.2.0, Copyright (c) Zend Technologies with Zend OPcache v8.2.0, Copyright (c), by Zend Technologies with Xdebug v3.2.0RC1, Copyright (c) 2002-2022, by Derick Rethans

The next step is to confirm your webserver is seeing PHP 8.2. Add a test.php script to your server root:

```php
<?php
phpinfo();
```

Browse to your localhost/test.php and confirm it says PHP 8.2. Then delete it.

### Make sure error\_reporting is set to E\_ALL

Local development machines should have **error\_reporting = E\_ALL** in *php.ini*. This will show all potential problems in your code such as new depreciations in 8.2

### Update composer

This is a critical step. You may need updated packages for PHP 8.2.

### Run unit tests!

This is a prime reason for unit tests. Fix any errors that come up. The most common will be dynamic properties in classes. The PHP team has plugged this hole that most scripting languages allow. You now must declare all properties a class uses or you will get a depreciation warning. This is a great feature, as it helps detect typos and refactoring issues.

### Exercise your site

While your unit tests should cover all use cases, they rarely do. Try to hit as many different types of pages as possible on your local machine. Don't forget about cron jobs or API interfaces that are not user-facing.

### Update any packages you maintain

If you are a package maintainer and have not already made sure your package is compatible with PHP 8.2, now is the time to upgrade. I recently found I had to update versions of GitHub actions to avoid depreciated configurations. Make sure you are testing PHP 8.2. And now is the time to reconsider [support for older versions](https://blog.phpfui.com/the-costs-of-legacy-support). A good rule of thumb is to only support ["supported" versions of PHP](https://www.php.net/supported-versions.php). I also will drop older versions if they cause any grief with unit tests, package support, or even automated code formatting conflicts.

### Submit PRs for any packages you use that are not PHP 8.2 compatible

Often with more mature packages, new versions of PHP can cause issues. While major packages are often updated to the latest version of PHP before it is released, not all packages are updated regularly, even if they are widely used and actively supported.

Be kind and submit a [PR](https://github.com/scrivo/highlight.php/pull/94). If you can't figure out how to fix an issue, at least open an Issue [explaining the to maintainer what the problem is](https://github.com/soundasleep/html2text/issues/100). Often it is just an [oversight](https://github.com/scrivo/highlight.php/issues/99).

### Get the rest of the team on 8.2

It makes sense to have just one person update to a new version of PHP to test the waters. Once you have confirmed your local machine runs with PHP 8.2, you will want to get the rest of the team up on 8.2. I generally document machine setups from scratch, as it helps onboard new developers. The same applies to PHP upgrades.

### Update your CI pipeline

Make sure your CI pipeline supports the new version of PHP. You can probably now also stop supporting the previous old version of PHP you were using before the last time you updated the pipeline. Your pipeline only needs to support the current production version and the upcoming version.

### Update the development server to PHP 8.2

The development server often sees more use than your local machine, so time to get it up and running PHP 8.2. Your error reporting pipeline should warn you of any issues. Again, error\_reporting should be set to E\_ALL in php.ini to help find issues.

### Update QA and staging servers after the current release cycle

At this point, you should be fairly confident your PHP code is capable of running under 8.2 and you need to start pushing 8.2 to more environments and users, but not to production just yet.

### Decide when to go live with PHP 8.2

OK, this is the big hard step most management types hate, upgrading something that "works". I generally watch the PHP updates and see what kind of issues are exclusive to the new PHP version. It generally turns out that most issues in a new release of PHP are in older versions as well. I good rule of thumb is it wait for 2-3 releases before deploying to production.

If you still get pushback from the higher ups, just remind them that Ford Model Ts still "work" but no one uses them as a daily driver. Upgrading to modern infrastructure is always time well spent. The last thing you want to happen is being 4-5 versions behind when a major security issue is found. Not fun. Upgrading regularly (every year in the case of PHP) is the right approach. Not too many changes at one time, but often enough you don't get left behind.

### Wait one release cycle for PHP 8.2 features

Once you have PHP 8.2 in production, you should wait one release cycle to start using new PHP features. This way you can back out if a disaster hits.

### Enjoy PHP 8.2!

And now you are all set to do it again next year. Once you have done the process all the way through, you are ready for the next time!