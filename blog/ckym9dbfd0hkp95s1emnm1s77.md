# The attack of the 50 mile wide open source supply chain!

We have all been reading about supply chain attacks from open source software.  And if you have not been reading about it, you should be.  This is a huge issue ripe for exploitation by anyone with world wide consequences.  These are just two of many:

1.  [A 'Worst Nightmare' Cyberattack: The Untold Story Of The SolarWinds Hack](https://www.npr.org/2021/04/16/985439655/a-worst-nightmare-cyberattack-the-untold-story-of-the-solarwinds-hack) 
2. [Hacker Infects Node.js Package to Steal from Bitcoin Wallets](https://www.trendmicro.com/vinfo/au/security/news/cybercrime-and-digital-threats/hacker-infects-node-js-package-to-steal-from-bitcoin-wallets) 

### Defining the problem
You can't actually solve a problem you don't understand, so lets define the issue.

First, open source software, by definition, includes the source code for the software.  This is a big departure from the original method of software distribution that relied on binary images from trusted vendors and installed on machines. In the open source model, you have access to the code.  You can even suggest changes to the code, or modify it yourself if you are the package maintainer. Most open source is developed by volunteers that want to share their work (and use others shared work) to make software and our world a better place.

Second, we all trust open source software to do what is says it will do, but why do we trust it? Because a bunch of others are using it? Have you examined all the lines of all the packages you are using? Do you personally know the maintainers?

In a nutshell, your project that relies on open source software has a 50 mile (or choose your unit of measurement here) wide open security hole that allows third party authors to run their source code on your system.  If you are not using open source software, is not an issue for you, so you can stop reading.  

I just finished reading this post [You're running untrusted code!](https://frankel.hashnode.dev/running-untrusted-code) and it sums up the issue fairly well.  But lets get very specific about what actual attack vectors look like.

### Attack Vectors

1. **Typos:** I use PHP and the [Font Awesome](https://fontawesome.com/) icon library.  The authors kindly support an install from [Packagist.org](https://packagist.org/packages/fortawesome/font-awesome).  Did you catch the typo?  No, click on the link and see if you can find it. Give up? The github user for this library is actually foRtawesome and not foNtawesome!  Now I believe this is the correct package by the correct author, but a lower case r looks a lot like a lower case n and I did a double take a while back when I noticed this.  So someone could publish a rogue package with a typo, and you have just installed who knows what.
2. **Abandoned Packages:** In the open source community, many packages are [abandoned](https://github.com/jamesssooi/Croppr.js).  The original maintainer no longer responds to issues or pull requests. I have personally had this happen to [me](https://github.com/ZContent/icalendar/issues/22) many times. In most cases, I find  [another better supported package](https://github.com/paquettg/php-html-parser/issues/294) and port my code. Often it is a simple port.  But sometimes it is not. So have I two choices, do the hard port, or [fork the project and maintain it](https://packagist.org/packages/phpfui/icalendar). Other users may find my fork, and it may become the new master if enough people find my fork.
3. **New Maintainers:** Open source is a community effort and many projects have more than one maintainer. Often the original author wants to stop supporting the project, so they recruit a new maintainer, and they go off into the sunset.  So now the package you have been using has another person maintaining it.  You may not even realize the maintainer changed. In fact, the original maintainer may have never met the original maintainer. It is just a matter of trust that the new maintainer will do the right thing.
4. **Rogue Maintainer:** Of course, anyone can publish a package.  [Who knows what evil lurks in the hearts of men?](https://en.wikiquote.org/wiki/The_Shadow)  Or [state actors](https://www.baesystems.com/en/cybersecurity/feature/the-nation-state-actor) for that matter. The package may indeed just be a well done honeypot to suck developers into using a package.
5. **Hacked Account:** [Stolen accounts](https://www.bleepingcomputer.com/news/security/github-attackers-stole-login-details-of-100k-npm-user-accounts/) are becoming more common as Open Source adoption increases. A rogue actor gets admin access to a GitHub account, adds bad code to the repo and then publishes a new version.
6. **Binary Downloads:** And now are at the actual 50 mile wide security hole for any non-source download from open source. Binary downloads require 100% trust from you to run on your machine. Neither Java or C# have any mechanism to insure that the binary you are downloading from an open source package manager has not been compromised. While the source code looks fine, what the binary was actually compiled from is anyone's guess.

So those are the primary attack vectors in open source.  For scripting languages, number 6 tends not to apply, unless of course you are minifying source code to reduce download bandwidth, which obfuscates the code enough that it might not be what it says it is.

### And the solution is....

Find out in my [next post](https://blog.phpfui.com/managing-supply-chain-risk).  Till next time.


