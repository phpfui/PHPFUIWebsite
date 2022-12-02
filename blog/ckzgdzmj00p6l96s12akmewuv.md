# PHP Namespace Best Practice

I'm not going to cover the technical side of PHP namespaces, there are plenty of tutorials on this topic that are easily found.  Instead, I am going to concentrate on best practices for namespaces, because many developers don't seem to understand how to use them.

### First, Some Definitions
#### The global namespace
In PHP, the global namespace starts with a backslash (&bsol;) and nothing else. PHP owns the global namespace and you should not be adding to it with a few exceptions.  What do I mean by "PHP owns the global namespace".  Simply PHP is allowed to put things into the global namespace because PHP defines what PHP means.  All library functions are in the global namespace.  strlen, count, str_replace are all examples of library functions in the global namespace.  PHP is free to add a new function or class in the global namespace and this could break your code when you upgrade to a new version of PHP. 

#### Use \ for everything in the global namespace
Best practice in PHP is to prefix all calls to global functions and classes with a leading &bsol;. For example, don't do this:

~~~PHP
$length = strlen('A string I want to know the length of');
$reflection = new ReflectionClass('MyClass');
~~~

Instead do this:

~~~PHP
$length = \strlen('A string I want to know the length of');
$reflection = new \ReflectionClass('MyClass');
~~~

There are two reasons to do this.  First, it shows explicitly what function or class you are calling (the global version and not something in the current namespace), and second, it is actually faster for PHP to figure out what you are doing and not have to worry about looking up the name in the current namespace. This may seem like a trivial optimization, but in the end, all these things add up (time is cumulative) and eventually time matters.

#### Top Level Namespace and Sections
The Top Level Namespace is the very first section of a namespace.  This is the most import part of a namespace, followed by the next section, and so on. As we will see in a bit, naming conventions are important.

#### The Bottom Line
Don't put things in the global namespace.  **All your code should be in a namespace!**

### The \App namespace is yours, use it!
When writing a PHP project, you can claim the \App namespace for yourself and your application.  This is a widely accepted standard.  All the code in your application that you or your team write should be in the \App namespace (and child namespaces, more on that later).

### Reserve your namespaces now
If you are working for company, and want to make company wide projects available, your top level namespace should be your company name.  Search for it on [packagist.org](https://packagist.org/?query=google) (Google's namespace is Google for example) to make sure it is not already in use.  If it is, and it is not your company, add something to the namespace to prevent it conflicting in the future (maybe add LLC or Inc to the end of the namespace for example).  You don't have to publish anything from your company, but it is nice to know you have a namespace that should not conflict at some point in the future.

The next thing you might want to do is reserve your own namespace if you plan to do any open source projects.  This could be your GitHub user name for example, or just another namespace you made up, or one that relates to an open source project you are developing. Again, search for any existing usages [packagist.org](https://packagist.org) before deciding on a name.  Then publish a package to reserve the namespace.

### Uppercase The First Letter Please!
Standard PHP naming convention is to uppercase the first letter of all namespace sections and uppercase the first letter of a class.  This goes toward readability of PHP in general.  Method names, members and variables are should start with a lowercase letter.

### DRY namespaces and class names
An important thing to remember is the class name is really part of the namespace in a sense.  While you can have a class and a namespace share the same name, you should consider the class name as part of the namespace.

In programming circles, **DRY** is a TLA (Three Letter Acronym) for "Don't Repeat Yourself", but as you look around in common packages, this rule is broken all the time.

Let's look at a [commonly used package](https://packagist.org/packages/symfony/process) and how to improve it.  The namespace is [\Symfony\Component\Process\Pipes](http://phpfui.com/?n=Symfony%5CComponent%5CProcess%5CPipes).  So far so good. Notice each section starts with a Capital letter. But there is a problem.  **Pipes** is plural.  Next rule:

### Don't use plurals in namespaces
Namespaces qualify a class.  A class is singular.  Namespaces should be singular, since a class is singular, and they are part of the same thing, the namespace.  While you may have many classes in a particular namespace, each class is it's own entity.  It is just grouped with other classes.  The group does not need to be plural, as you refer to just one class as a time.

So here is the class hierarchy for \Symfony\Component\Process\Pipes:

- \Symfony\Component\Process\Pipes\AbstractPipes
- \Symfony\Component\Process\Pipes\PipesInterface
- \Symfony\Component\Process\Pipes\UnixPipes
- \Symfony\Component\Process\Pipes\WindowsPipes

You will notice there are only two concrete classes (concrete classes are ones that can actually be turned into objects), UnixPipes and WindowsPipes, which correspond to the two major OSes everyone uses, Unix (Linux) and Windows.  The other two classes define what the two concrete classes can do (ie. their interfaces).

So notice the class hierarchy is not DRY.  The word Pipes (should be Pipe) is used in multiple places in the same namespace / class.  Here is a better hierarchy:

- \Symfony\Component\Process\Pipe
- \Symfony\Component\Process\PipeInterface
- \Symfony\Component\Process\Pipe\Unix
- \Symfony\Component\Process\Pipe\Windows

So what have we done?  First we made Pipes singular, and also made everything DRY.  No multiple Pipe(s) anywhere in a class name.  The abstract class Pipe is now in the Process namespace.  But that is fine since it is the parent class to both the Unix and Windows concrete classes, and sits just one level up.  We also have a PipeInterface in the same namespace to avoid a duplicate Pipe. Interfaces tend to have a descriptive name in them, as they can't just be called Symfony\Component\Process\Pipe\Interface, since Interface is a reserved word in PHP (obviously).  We could solve this problem in PHP 8 or higher with a interfaces namespace, such as Symfony\Component\Process\Interface\Pipe, as reserved words can be used in namespaces since PHP 8, but this keeps it compatible with older PHP versions.

### Child Namespaces
Child namespaces (anything past the top level namespace) allow you to further refine and describe your classes.  Use the child namespace to group and describe your classes. But don't abuse it!

### Extra Long Namespace Abuse
A common problem with namespaces is extraneous children and namespaces that are too specific and too long.

In our above example, do we really need both Component and Process?  We need Pipe for sure, but we could probably live without one or the other, or even both.  What is wrong with Symfony\Pipe?  Pretty simple.

### Some Exceptions
1. In the above example, we had to add a name to Interface, to avoid a PHP reserved word.
2. Windows is plural, but is a proper name, so makes sense to use it.
3. You can use the global namespace to shorten things, for example, \T() can be a translation function.  But keep this to a minimum.  And shorter is better in this case.

## To Summarize:
1. Don't use the global namespace.
2. Use the \App namespace for all your application code.
3. Reserve a namespace for your common libraries you may need.
4. Upper case the first letter in all namespace sections and classes.
5. Don't use plurals in namespaces.
6. Keep namespaces and classes DRY.
7. Avoid extra long namespaces / class names.
