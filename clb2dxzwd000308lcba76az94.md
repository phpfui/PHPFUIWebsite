# Keeping a Weed Free Lawn

PHP is an interpreted language, meaning it is evaluated at runtime and not before during a compilation step. While compiled languages have the ability to mostly self-check the code, interpreted languages like PHP and even JavaScript do this on the fly at runtime. While this is great for quick turnaround times in development, as there is no compile and deploy step, it can haunt you in production.

On a production system, you want to constantly monitor for errors. Errors can range from uncaught syntax errors that have crept in due to sloppy oversight, to hard to find data dependent configuration errors that are only seen in production usage. In all cases, you want to resolve these errors as soon as possible to avoid system outages and flustered clients when the system does not work as it should.

One solution is to fly blind and not report errors or warnings in production. This is of course an extremely bad situation. A common configuration is to set error\_reporting in the production php.ini to something other than [E\_ALL](https://www.php.net/manual/en/errorfunc.constants.php). A common kludge is to turn off warnings and depreciations simply because they are not fatal. Things work after all even if they are present, right?

Another solution is to simply tolerate a noisy error log. Hey, it works right? Don't worry about it!

The problem with this approach is this:

![Cnidoscolus_stimulosus.webp](https://cdn.hashnode.com/res/hashnode/image/upload/v1669684422938/5zOQqyQB2.webp align="left")

Looks like a nice pretty flower right? Except don't touch it or you might be in for a surprise. Cnidoscolus Stimulosus has stinging hairs that can cause sharp pain where you make skin contact.

If your error log is filled with warnings and nontoxic plants, how are you going to figure out what not to touch and what is harmless?

### A Weed Free Lawn Exposes The First Weed Quickly

The proper solution is of course to report and fix all errors and warnings as soon as they are seen. One of the most common sources of noise in an error log is new warnings and depreciations after you upgrade to a new version of PHP. For example, PHP 8.2 introduces a depreciation for undeclared class properties. Not declaring a class property has been acceptable PHP since the advent of classes in PHP 4. You can just ignore that right? The code will continue to work as before, so just ignore it!

But here is the problem. Innocuous warnings allow serious errors to blend into the background forest of errors. They become unseen.

### An Empty Error Log Is Bliss

While your app may have other bugs, at least it has no machine detectable errors. This means you have a higher confidence your code is working as you expect. True peace of mind.

### Errors Are Now Instantly Obvious

By not having to mentally sort out which messages might be a problem, you can simply fix whatever comes up in the error log. And the sooner it gets fixed, the sooner it is out of the error log and the sooner it will not be affecting a client.

### Error Log In Your Pocket

While this is all good, if you don't have vision into the error log at all times, you might miss something. In my [next post](https://blog.phpfui.com/php-error-logging-to-slack), I will show you how to display the error log on your phone. And remember, because you keep a weed free lawn, you won't be seeing much anyway.