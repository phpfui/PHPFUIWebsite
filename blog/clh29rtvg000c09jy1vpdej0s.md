---
title: "Getters and Setters vs Public Access"
datePublished: Sat Apr 29 2023 17:41:33 GMT+0000 (Coordinated Universal Time)
cuid: clh29rtvg000c09jy1vpdej0s
slug: getters-and-setters-vs-public-access
cover: https://cdn.hashnode.com/res/hashnode/image/upload/v1682784596092/732f20ec-a53c-4c6d-a31f-ffb3dd324d43.png
tags: php, classes, object-oriented-programming, php8

---

In my last posts, I explored just what objects are and how to extend them (inheritance) or use them (composition). The big takeaway from this: objects should be completely self-contained and manage their state and consistency. This is normally done without letting the users of the class directly access the internals of the class. Instead, the object provides interfaces to the data so access can be controlled, monitored and validated to make sure the object is not compromised by some rogue developer.

### Who Owns What?

Traditionally this has been done with Getter and Setter methods. For example, you might have a Book object and have a title, author(s), publisher, etc. In old-school OO design you would have the following methods:

* getTitle() : string
    
* setTitle(string $title) : self
    
* getPublisher() : Publisher
    
* setPublisher(Publisher $publisher) : self
    

While this gives you complete control over the object, it becomes a little clumsy to use in day-to-day programming. For example, this:

```php
$book->setTitle('My PHP Book Title');
$book->setPublisher($publisher);
```

seems less user-friendly than this:

```php
$book->title = 'My PHP Book Title';
$book->publisher = $publisher;
```

In this case, public access for the title and publisher seems to make sense. The Book object exists so we can manipulate it, and if we need to change the title, then we want to do that easily since we know what the title should be and not the Book object. In this sense, the user owns the content of the title, while the Book class is only responsible for storing whatever the user provided.

### Objects Are Types

Classes also provide type safety by their mere existence. PHP has long supported using class type information on method and function calls. This helps ensure your program is working as expected. Notice the difference between these class interfaces:

```php
public function setPublisher(int $publisherId) : self;
```

verses an object oriented approach:

```php
public function setPublisher(Publisher $publisher) : self;
```

By requiring a class object of type Publisher we ensure we are not assigning a random integer to the publisher. By exposing the underlying type of how we are going to store the publisher relationship, we have pushed in implementation detail (we are storing a publisher as a relation) into the face of our clients. Now our users have to deal with a specific detail of how our database works. And at the same time, we have made things less robust and more error prone.

### Make Objects Type Safe

Notice the class is automagically storing the relationship of the publisher. We are providing an object interface to the publisher, and not just a string. This is because a publisher probably has other properties we want to track elsewhere in the database, like how to reorder a book! In this case, we are not storing an integer pointing to the primary key of the publisher table, but rather the publisher object itself. While the setPublisher method makes this clear, in PHP, the class can enforce this itself with magic methods (more on this next time). This makes the class more type-safe since we can't assign a book id to a publisher id and create a database inconsistency.

The more you leverage treating classes as types and hide the implementation details from the user of your class, the more readable and reliable your code becomes. An example of why this is worth doing might be making the data you reveal to users of your website more anonymous. If we were to exposer integer ids for records in a url, like **/member/57292**, we can deduce there are probably 57292 users and that user 57291 also exists. But if we decide to go with a GUID type of primary key, then we can obfuscate this information from the public view and other users. And if we only put classes into our interface, the users of our class won't have to deal with us changing the implementation and having to deal with the fact that we have pushed an implementation detail into their faces.

### Use Plural and Singular Correctly

Now let's consider the case of authors. While most books have just one author, enough books exist with multiple authors, so our Book class needs to deal with that. And while we know what authors are associated with a book, the Book object only needs to know that it needs to store and retrieve multiple authors on a book.

In this case, a public list of authors would be an extremely bad idea. While you could add an array of authors as a public property, who is to say what is in that array? In PHP land you can add anything to the array, not a great idea if you expect them to all be authors!

So the Book class needs to control access to the list of authors. Since we are dealing with more than one author (as opposed to the title where we only have one per book), we should use the plural form. This indicates to the class user that there can be multiple authors per Book. For example:

```php
public function addAuthor(Author $author) : self;
public function removeAuthor(Author $author) : self;
public function getAuthors() : iterable;
public function setAuthors(iterable $authors) : self;
```

This allows us to add or subtract any individual author, but also get a list of all authors and set the list of authors. Why would we want to set the list of authors? To provide an order of authors. Most books will either list the authors alphabetically, by importance, contributions or agreement.

Notice we have not set how the authors are stored in the Book class. As a user of the Book class, we don't care how the authors are stored, just that we want to store these authors and get them back in the future, in the same order we added them. This is solely the responsibility of the Book object and not the user of the class, so we wrap this functionality to take control from the user, but allow the user to do what they need.

### Provide Useful Methods

A class may present other relationships it is aware of as a convenience to the user. For example, an Author class may present the following methods:

```php
public function books() : iterable;
public function publishers() : iterable;
```

The books() method would return all books by the current author. Same for publishers. While you could easily get this information from the database, the Author class makes it easier to use without cluttering up your code with random database calls. For example:

```php
echo "Other books by {$author->fullName()}:\n";
foreach ($author->books() as $book)
  {
  echo $book->title . "\n";
  }
```

While the above example is trivial and will list all the books for the author, and probably the current book you are viewing, it does show the simplicity of an object-oriented design. Here are some other ideas for getting the author's books:

```php
public function mostRecentBooks(int $limit = 5) : iterable;
public function mostPopular(int limit = 5) : iterable;
```

Notice what we have implicitly done here. We have put the logic of getting the most recent and most popular books by an author in one place. So when we need to change this logic, we can change it in one place and not have to track down separate database queries scattered throughout the code base.

## Takeaways

When designing classes, think about who is responsible for the data in the class. If the user of the class is the arbiter of the data, then let the user of the class deal with it directly. If the user of the class should not concern themselves with something, protect the inner workings from outside forces.

Classes are types. The class should enforce proper usage of itself and provide functionality for its users.

Provide type safety when and where ever possible. Adding a public array to a class is almost always a bad idea. Typing a public property is a good idea, but make sure you enforce the type.

Name things correctly. If something has multiple versions, use the plural form of the word, otherwise keep it singular. This helps users understand the class.

Provide useful methods to users of your class.