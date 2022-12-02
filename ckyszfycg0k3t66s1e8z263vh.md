# The Genius of PHP's Autoloader

In my previous post, I talked about [the genius of PHP](https://blog.phpfui.com/the-genius-of-php), but now it is time to talk about the absolutely most genius thing about PHP, the autoloader!

But before we get into this particular genius, we need a little history lesson in computer languages. Way back in the 1950's and the invention of the first high level computer language. [FORTRAN](https://en.wikipedia.org/wiki/Fortran) rescued programmers from assembly language, which hard-coded you to a specific machine architecture. But there was a problem. How do we reuse code from one program in another? After all, we need to do the same thing in multiple programs, why not reuse what we already created? But how?

### Introducing the INCLUDE statement

The include statement was finally formalized in FORTRAN 77, but many implementations had some way to do that before. So the include statement became a way to reuse code and create a standard library of debugged and useful functions. You simply included a file with known functions and used them. And this worked fairly well. And fast forward 70 years to now, and guess what? We are still using include statements! Hard to think of another technology we use pretty much verbatim from the 1950s, but here we are in the 2020s and still using include statements every day (looking at you template based views)!

### So What is Wrong with Include?

Include what? What are you including? Are you sure? This is the basic problem with include. You have no idea what you are including. In PHP, you start immediately executing the code you include. Does this sound like a bad idea? Yes, it is! Included files can not be type checked. You can't insure a change on either side of the include (includer or includee) will be compatible with the other side. You are praying things just work. We all know how that ends.

With an autoloaded class, the developer is in charge of when and how the new class is used and executed. It is type-safe as much as PHP will allow. No surprises or unexpected output.

### Enter the autoloader

So instead of placing random include files all around your code, you can use the autoloader. In the past, you may have seen this:

```PHP
require_once 'MyClass.php';
$anInstance = new MyClass();
```

But with the autoloader, you can simply just include the autoloader once per file, and then not worry about individual includes:

```PHP
require_once 'myAutoLoader.php';
$anInstance = new MyClass();
$otherInstance = new MyOtherClass();
$thirdInstance = new MyThirdClass();
```

If you are using a controller and not hard-coded file paths (ie. /Person/edit/123 and not PersonEdit.php?id=123), then you can skip requiring the autoloader file completely. It will be included once when the controller runs, and then the controller will leverage the autoloader to load classes automatically. If you are using hard-coded PHP file names, then you will need to include the autoloader on every PHP file.

### So why is the AutoLoader a genius feature of PHP?

Because it allows fully autonomous classes that are not dependent on importing (another form of include really) the correct module. For example, in C++, you have to include a header file to use a class:

```C++
#include "my_class.h"
using namespace N;
int main()
{
    my_class mc;
    mc.do_something();
    return 0;
}
```

In C# and Java, you have to tell the compiler to include a file in your configuration so it knows about it. This is an extra step of overhead that PHP developers don't have to deal with. In PHP, your autoloader will load the class, you just have to make sure your PHP is discoverable by the autoloader.

### Under the Autoloader covers

So how does this all work? Enter [spl\_autoload\_register](https://www.php.net/manual/en/function.spl-autoload-register.php). This function registers your autoloader and it would look something like this:

```PHP
define ('PROJECT_ROOT', __DIR__);
spl_autoload_register(function ($className)
{
    $path = PROJECT_ROOT . '\\' . "{$className}.php";
	$path = str_replace('\\', DIRECTORY_SEPARATOR, $path);
	if (file_exists($path))
        include_once $path;
});
```

Here is how it works:

1.  When PHP comes across an object or function it does not already know about, and you have registered an autoloader with spl\_autoload\_register, then it passes that unknown name to the function you registered, in this case, an anonymous function.
    
2.  That function then constructs a path to a file that should exist according to the project setup. In this case, it is the directory where the autoloader file lives, plus the full namespace and class name. It also adds '.php', as we know it should be a PHP file.
    
3.  If the file exists, then we include it and we are done, as PHP has now included the file, so it will know about it on return of this anonymous function.
    
4.  If the file does not exist, we don't do anything and just return. PHP will then still not know how to resolve the name and throw an error.
    

There are a few things you need to know for a successful autoloader:

1.  Make sure the class name and file name are in the same case and spelled the same. On case-insensitive file systems (like Windows or OSX), if the case does not match, it will still work, but when you deploy on Linux, things go south quickly (don't ask how I know that).
    
2.  Names will include the full namespace with the \\ character exactly as written in PHP.
    
3.  Make sure your directory structure is set up to match the PHP namespace and case sensitive (see #1.)
    
4.  All autoloaded files should begin with &lt;?php and not include any statements not encapsulated in the corresponding class. This prevents unintended code execution.
    
5.  Only include one class definition per file. This ensures the autoloader can find it correctly.
    

### Composer autoload.php file

You can also be lazy and just use the Composer generated autoload.php file. As I will explain in a future post, this is not a good idea for a couple of reasons, but it is a reasonable first and quick autoloader configuration.

### And why is PHP one of the only languages to implement an autoloader?

Other than Perl, there are not many languages that use autoloaders. Even Python does not have a generic autoloader. C++ is a notorious language for relying on include files. Why is this? Laziness by language definers from what I can tell.

For example, C++ could define a standard implementation supplied autoloader interface. Just like PHP, when the compiler comes across an undefined class, it could pass the fully qualified class name to the implementation defined autoloader. The autoloader could then return a file path, or even the contents of the file, back to the compiler. This would then be loaded as if the file were included normally.

### The future

The PHP autoloader is a huge part of the genius of PHP and makes coding in PHP much more pleasant. I predict will be a feature added to all languages at some point. Just a question of when everyone realizes computers should work for us, and not we for them.