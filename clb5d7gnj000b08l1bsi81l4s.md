# Why Use PHP in 2022?

I saw a question on Quora the other day that said something like **"Why use PHP?"**, so I thought I would list the reasons I use PHP and not another super annoying language.

### Fully Open Source

First, it is 100% open source. I don't have to worry about licensing, or being mostly maintained by evil company X. It has an open process for adding new features to the language and a predictable release schedule.

### Easy to Upgrade

It has been easy to upgrade from previous versions of the language to the latest release. You can't say that about Python, Perl or several other languages. Often a new version of the language impacts older users preventing them from upgrading to more modern features. Each of my PHP upgrades from 4.2 to 8.1 (and soon to be 8.2) has been relatively painless. Tools such as [Rector](https://getrector.org/) make it even easier to move between versions with both up and down grade paths.

### Great Documentation

You can say whatever you want about PHP, but the documentation for the language is some of the best I have ever seen, including classic IBM documentation from back in the heydays of PL/1. Contrast that to what passes for documentation from other companies with a paid staff, and you can appreciate the quality of the documentation.

### Great User Community

One of the features of the PHP documentation is user comments. These are curated and often explain subtle things that may not be covered in the official docs. Users often contribute source code to help solve a specific problem, or offer tips they found while trying to get something to work. These insights are particularly helpful when trying a new feature or function.

The user community also extends to Stack Overflow and other developer help sites. In other languages I have used, the breadth of the user community is much smaller and often it is hard to find the solution to your problem. With PHP, it is really easy to find a solution to any problem you have.

### Huge Selection of Open Source Packages

[Packagist.org](https://packagist.org/) is a great resource for finding PHP packages to solve your problem.

### Amazing Dependency Management

I have used several dependency managers in other languages and I find Composer is the best in class. Other dependency managers are slow, not easily configurable, or just plain have bugs and/or lack features that are in Composer.

### Well Matched To Web Development

PHP stands for PHP Hypertext Processor, and that is exactly what it is. The PHP language processes things into hypertext. I would not use PHP for much beyond the web and other text-based things, like command line programs, but it is ideally suited to processing text, and the web is text-based.

And since PHP started as a web-based language, it has all the supporting functions you would expect in a web-based environment.

### Easy to Learn

PHP is extremely easy to use. Even novice developers can be quickly productive writing basic PHP code to produce a website. This is also PHP's Achillies Heal, it is so easy to write code, you often get newbie developers with no architectural skill writing bad code. But it is also easy and a pleasure to write great object-oriented PHP code.

### Easy to Deploy

My deployment cycle consists of doing a git pull, deleting a few files and running any new migrations. Super fast, simple and reliable. Compare that to the horror stories you hear about other [language](https://stackoverflow.com/questions/2741507/a-simple-python-deployment-problem-a-whole-world-of-pain) [website](https://medium.com/@nikhilshinde57/issues-with-deploying-nodejs-application-on-azure-383e3b38e1b4) [deployments](https://stackoverflow.com/questions/11796838/web-deployment-task-failed-could-not-connect-server-did-not-respond).

### Fast Deploy / Test Cycle

Unlike compiled language, PHP is interpreted at runtime. While this may be a problem for high-volume sites, it means as soon as you save your PHP files to disk, you can test your site. Compare this to a compiled or transpiled language and you have a delay (and at least one other step) before you can test. While it may not seem like a big deal to wait, this can seriously degrade your ability to make fast changes to your CSS, HTML and even logic, as you polish your site.

### Widely Supported Hosting

Every hosting service will offer PHP support. Not true for just about any other language. Often you have to deploy the language yourself if you can get it to work at all. Just running a JVM can be problematic unless your hosting service specifically supports it.

### Good Object Model

While not perfect, PHP has a decent object model you can use for object-oriented development. It lacks a few things like operator overloading so you can't truly add new scalar-like types to the language. But it handles most OO use cases quite well.

### Supports Procedural and Functional Style Development

If you have never figured out the OO style, you can still do the older Procedural and Functional styles of programming. PHP supports both very well. And PHP does not force you into any particular style. You can mix and match.

### Multi-Platform

PHP runs equally well on Linux, OSX or Windows operating systems. And since it is written in C, it can be easily ported to any future OS or computer architecture fairly easily if needed. So I can develop on Windows with a great UI experience and deploy on Linux. The only issue tends to be both Windows and OSX are not case sensitive, whereas Linux is, so you can get into autoloading issues if your file case does not match.

### PHP Is FAST!

For an interpreted language, PHP is at the [top of the pile](https://www.techempower.com/benchmarks/#section=data-r21). The fastest PHP combo tested came in at position 31. All faster tests are from compiled languages. Python first shows up at position 236. With just one anomaly, JavaScript comes in at position 128. Ruby does not show up till 280.

While you can cherry-pick benchmarks, PHP does quite well for any combination and is an indication of the speed of PHP in general. Add speed of development and deployment, and PHP looks like a solid choice.

### Full Reflection

Since PHP is a scripting language, and you can effectively create PHP on the fly, Reflection classes come in really handy to check out classes and objects at runtime. Reflection classes allow your code to inspect any class or object at run time and pull out the entire class or object definition, including access to protected and private members. I used this functionality to create fully hyperlinked PHP class documentation on the fly for any autoloadable PHP class. Check out [PHPFUI](http://www.phpfui.com) for a live demonstration.

### And Finally, it is just FUN to write in PHP

And that is the main reason I still write PHP in 2022. Because if it is not fun, why bother?