# Comment Best Practices

How many times have you seen this:
```php
/**
 * @param int $id
 * @param string $name
 * @return string
 */
public function getFileName(int $id, string $name) : string
```
This is a prime example of useless comments, and unfortunately, I see this all the time. Now in PHP 5.6 and earlier, it may have made some sense to tell the next developer you are expecting the first parameter to be an integer, and the second should be in a string, but from PHP 7.0 on, you can specify this in the language itself, so why are you commenting it?  The comments add exactly NOTHING!  In PHP 7.1, you could type return values, and then the `@return` comment became useless.

In my previous [post](https://blog.phpfui.com/why-i-dont-use-use) I talked about cognitive load, which is the amount of brain power you are expending to make sense of what is in front of you.  Useless comments just add to cognitive load and give you nothing in return.  Lets all agree to put them out of their misery and nuke these every time we see them.

# Documentation Best Practices
And this brings us to documentation best practices.  The first best practice is to ...

### Write Clear Code
What do I mean by writing clear code?  Well, name variables that make sense in the context where they exist.

In the bad old days of FORTRAN, you often had developers coming from the world of mathematics where the tradition was to use the minimal amount of letters in variable names. And FORTRAN was very happy to help out. Early implementations of FORTRAN had variable name character limits (like 6), as memory was very expensive, so you tended to use J over counter which saved you .01% of available memory (hey, it adds up fast!).

Now J in a counted for loop is really not so bad.  But when you code consists of A, B, C, E, I, J, and K, things get confusing fast.  Also note that variables A, B, C and E were floats, while I, J and K were integers (oh how much fun!).  As you can see, this made for high amounts of cognitive load.

### Give your variables full names
$fullyPathedFileName is much better than $fileName, which is better than $name, which is better than $fn. $fullyPathedFileName is a great comment to the next developer.  You intended that it contain a full directory specification to file with the file name.  This variable needs no further comments.  If you had this as a parameter, it would not need any comment either, assuming you typed it as a string.

### Use proper pluralization
Use plural and singular names correctly.  Variable names that are plural should be able to contain more than one thing.  Singular names should only represent one instance.

Containers and arrays are classic examples where the plural form makes sense.  $invoiceIds makes sense that it would contain ids that point to invoices.  Where as $invoiceId would just be a single instance of an invoice.

### Use camelCase for variable names
Camel case (first letter in lower case, subsequent start of words are capitialized) makes things a lot easier to read. thisIsMuchEasierToRead than thislongstringofcharacters.  And of course $penIsland is probably a place you could sail a boat to, rather than someplace you probably don't want to go.  Underscores are also used, but less frequently in PHP, but have the advantage of being slightly easier to parse (hello explode).

### Use verbNoun names for Functions and Methods
In OOP (Object Oriented Programming), methods and functions tend to act on things and return things.  Name them appropriately.  In the above example, we are getting a file name.  We know this from the method name. In this case, we are probably NOT getting the file name, we are probably **generating** it from the parameters passed in.

A better name might be **generateFileName**.  But this leads to a bit of confusion.  Is this file name fully pathed?  Maybe we should name it **generateDirectoryFileName**.  That makes it even more clear what is returned.

Now let's fix up the parameters.  $id is not a great name.  It is obviously a number, but what kind of a number?  Shoe size? Waist size? Invoice Id?  And what is the $name variable doing?  It could be prefix, extension, or even a pretty name.

Let's try this again:
```php
public function generateDirectoryFileName(int $invoiceId, string $prettyName) : string
```
Now we have a better idea of what is being asked of us and what we can expect in return.  And notice anything?  No comments needed to tell us any of this information.

# When To Use Comments
So you might think you don't need to write comments if you can write clear code.  And while this is mostly true, you should comment things where needed.

### Comment complex code
While you should probably try to not write complex code, sometimes you are solving a difficult problem, and even though you have broken it down into smaller solvable parts, it is still overall fairly complex code.

In this case, you want to comment what the methods are doing.  Generally what the method is requiring be done before you can call it, what the method will do, and what it returns. If you name your method and parameters correctly, your explanation should make things obvious, but it always helps to add comments to each variable passed into the method.

And in the code itself, it often helps to explain what you are trying to do, but keep in mind, you may be able to tell your story with just simple well thought out variable names. 

### Comment classes
You should have a good docblock at the start of each class explaining how to use it. See [NanoController](http://phpfui.com/?n=PHPFUI&c=NanoController&p=d) as a good example of full documentation on how you should use a class.  Notice that the methods all have additional information on how to use them.

### Use namespaces and class names correctly
[Namespaces are part of the class name](https://blog.phpfui.com/php-namespace-best-practice).  Proper naming goes a long way towards letting people know how things work and relate to each other.

### Use MarkDown
[DocBlocks](https://docs.phpdoc.org/guide/guides/docblocks.html) support [MarkDown](https://www.markdownguide.org/).  Use it!

### `Readme.md` files
Another common problem is the lack of proper use of `readme.md` files.  While your application's `readme.md` file may just be copyright information, you really owe it to future developers to document the following:
* Minimum requirements
* How to set up a machine from scratch
* Coding standards
* System architecture
* Resources such as initial databases and procedures

If you are going to release a library on [Packagist.org](https://packagist.org/?query=phpfui), then your readme is really a sales document for why and how to use your package.  A good readme file goes a long way towards making a successful package. Also consider a [doc](http://phpfui.com/?n=Gitonomy%5CGit) [directory](https://github.com/gitonomy/gitlib/tree/1.3/doc) to include all your documentation.

### Generate docs for your code base
Generating and maintaining documentation for your project is now [super easy](https://packagist.org/packages/phpfui/instadoc). No
more excuses why you should not have [all your code fully documented](http://phpfui.com/?n=PHPFUI%5CInstaDoc).
