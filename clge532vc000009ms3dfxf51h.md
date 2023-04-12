---
title: "PHP Object Oriented Programming"
datePublished: Wed Apr 12 2023 20:23:51 GMT+0000 (Coordinated Universal Time)
cuid: clge532vc000009ms3dfxf51h
slug: php-object-oriented-programming
cover: https://cdn.hashnode.com/res/hashnode/image/stock/unsplash/a6N685qLsHQ/upload/a38b7226433fc2936dde3d59f42af314.jpeg
tags: oop, php, phpunit, object-oriented-programming, php8

---

I often see other developers having trouble with "Object Oriented Programming". Often they claim it does not work, or it gets "too complex", or hard to understand. And I have been there, done that in my youth, but I still use OO (object oriented) programming for most of my work simply because it is the best way to work, especially in PHP.

While this article uses PHP for examples, the concepts apply to all languages that correctly implement classes. Some languages don't implement classes correctly (looking at you JavaScript) and should not be used for OO programming.

## But OOP is "TOO HARD"!

I think the real problem here is people confuse "inheritance" as the only way to do OO programming. Inheritance is generally the last resort and least used OO feature, or at least it should be. OO Programming is really about the separation of concepts and their implementation. A class can wrap an implementation of a concept and that allows you to change the implementation without affecting the concept, or where it is used. This gives your program more resilience to the inevitable change that happens to useful programs.

## A Simple Example

Let's try an OO approach to a problem that does not involve inheritance: a **Die**!

A die is quite simple. The common die has 6 sides with the numbers (or dots) numbered 1 to 6. One side is always up. But some die can have more or fewer sides, depending on the game. A coin can be used as a die, it has two sides, heads or tails. A four-sided die looks like a pyramid (and in this case, does not have a side that is up, but down!) A twelve-sided die is starting to look like a ball. In our virtual world of die, we are going to assume you can have an odd size die (can you have a physical three-sided die?), but you might want to prevent that in some cases.

A die can also be rolled and has a value. The die sides may not be simply numbered, but have a pattern with a specific meaning. For this example, we will just implement a numbered die. In my next installment, we can use inheritance to implement patterns and more complex die imaging.

## ADie Class

So now we have determined the 3 properties of a die:

1. Number of sides
    
2. Ability to roll
    
3. Current value
    

Now time to implement. The first thing we need to do is figure out what is required in our class for it to work. Requirements of a class should be parameters to the constructor, in other words, an object of a die class must be made with the required fields. In our case, we need to know the number of sides a die has, so this becomes a parameter for our constructor.

The ability to roll is a verb. A verb is an excellent name for a class method. Class methods generally ask the class something (often called getters), or modify a class, which is the case for roll. Methods on objects should mostly be thought as verbs doing or getting something from the object.

Plus we need to get the current value of the die.

And finally, since die is a PHP reserved word, we will have to call our class ADie, which seems to be a nice single-sounding name.

So let's put it all together:

```php
class ADie
  {
  private int $value;
  public function __construct(private readonly int $sides = 6)
    {
    if ($sides < 2)
      {
      throw new \Exception(__CLASS__ . ' must have at least 2 sides');
      }
    $this->roll();
    }
  public function roll() : int
    {
    $this->value = mt_rand(1, $this->sides);
    return $this->value;
    }
  public function value() : int
    {
    return $this->value;
    }
  public function sides() : int
    {
    return $this->sides;
    }
  }
```

So what have we done here?

First, we require the number of sides. We are using the PHP 8.0 constructor property promotion feature to declare the $sides argument to be a private property of the class. We are also using the **readonly** attribute from PHP 8.1 for the $sides property. This is because ADie should not mutate itself while it exists. Then we default to the most common die size of 6 to be kind to our users. Next, we roll the die on initialization. This makes sense because a die always has a side facing up, but we don't know what it will be. And we don't want a developer to cheat by specifying an initial value. Notice how we used the roll() method in the constructor to get the actual value of the die. You can and should call other methods in the constructor if they are of use to you. We also test that the number of sides is two or more. This might point out an issue in your code, but is not strictly needed for the class, more like bulletproofing things to avoid potential bugs.

Next up is a simple roll() method. Notice it returns the value it computes as a courtesy to the developer if they want.

Finally, we have two public functions which return properties of the class. Notice the properties themselves are private. This means no child classes can mess with us, but they can get the information about our class if they need it. I added the sides() method because someone might want to know how many sides a particular ADie object has.

And finally, notice we did not inherit from any other class. ADie is a perfect example of a class that encapsulates an implementation (mt\_rand, or any other way of picking a random number), does not let the user of a class mess with its internals, but will also allow for inheritance (next installment) if needed. A perfect object!

## Let's Test It!

Before we go any further, let's test the ADie class to make sure it works as expected. We will use PHPUnit.

```php
class DieTest extends \PHPUnit\Framework\TestCase
  {
  public function testDefaultADie() : void
    {
    $aDie = new ADie();
    $this->assertIsInt($aDie->sides());
    $this->assertEquals(6, $aDie->sides());
    $this->assertIsInt($aDie->value());
    // make sure we exercise the roll method
    for ($i = 0; $i < 1000; ++$i)
      {
      $this->assertGreaterThan(0, $aDie->value());
      $this->assertLessThanOrEqual(6, $aDie->value());
      $aDie->roll();
      }
    }
  public function testLargeADie() : void
    {
    $sides = 12;
    $aDie = new ADie($sides);
    $this->assertIsInt($aDie->sides());
    $this->assertEquals($sides, $aDie->sides());
    $this->assertIsInt($aDie->value());
    // make sure we exercise the roll method
    for ($i = 0; $i < 1000; ++$i)
      {
      $this->assertGreaterThan(0, $aDie->value());
      $this->assertLessThanOrEqual($sides, $aDie->value());
      $aDie->roll();
      }
    }
  public function testBadADie() : void
    {
    $this->expectException(\Exception::class);
    $aDie = new ADie(1);
    }
  }
```

Now we have a working ADie class. But what can we do with it? Most uses of a die involve more than one. They are called **Dice**!

## Another Simple Example: Dice

First, what is the concept of dice? What are we trying to model and what interface do we want to present to the user of our dice class? In forming a concept for dice, we want to roll them for sure. But dice is plural for multiple die. How many dice do we need? Monopoly uses only two die, while Yahtzee uses five (if I remember from my youth). So our dice class needs to know how many die to model, and we need to roll them, but we also need to see the result of the roll. So the Dice class sounds like it needs to contain multiple ADie to work. But Dice is not a die. Dice are a collection of die. This is where people tend to go wrong with OO programming. But there is a very simple way of figuring out when to use inheritance or not.

## ISA and HASA Relationships

This is the fundamental question to ask when doing OO programming. Are you modeling something that is also something more basic, or does your model just have things?

**ISA** means "is a", as in an iPhone **is a** smartphone, as a Pixel 6 **is a** smartphone. They are both smartphones. They could inherit from a common SmartPhone class. An old-fashioned rotary phone is also a phone, but not a smartphone. But they are all phones, so they could inherit from a Phone base class. I will get more into inheritance in the next installment.

But in our case, dice are clearly not a single die. Dice is the word for multiple die.

**HASA** is short for "has a", or in the case of dice, has multiple die. So we want Dice to "have" ADie. **HASA** relationships are called "composition" as opposed to **ISA** relationships, which are known as "inheritance".

## Let's design a Dice class

We need our Dice class to hold multiple ADie. We also need to roll them. And finally, we need to get the values of the rolled ADie objects. We might also want the ADie objects themselves if they represent more than a simple value, for example, they have properties like names, images, etc.

```php
class Dice implements \Countable
  {
  private array $dice = [];
  public function add(ADie $dice = new ADie()) : int
    {
    $this->dice[] = clone $dice;
    return $this->count();
    }
  public function count() : int
    {
    return count($this->dice);
    }
  public function roll() : void
    {
    foreach ($this->dice as $aDie)
      {
      $aDie->roll();
      }
    }
  public function values() : array
    {
    $values = [];
    foreach ($this->dice as $aDie)
      {
      $values[] = $aDie->value();
      }
    return $values;
    }
  public function getDies() : array
    {
    $values = [];
    foreach ($this->dice as $aDie)
      {
      $values[] = clone $aDie;
      }
    return $values;
    }
  }
```

The first thing to notice about this class is that it has no constructor. Why? Because we can initialize the single property with an empty array. PHP constructors are optional if can initialize the object to a valid state with just property initializers. While Dice with no associated die is probably not useful or a valid use case, Aour class will work with no Die in it, so we don't need a constructor, the object is valid without one.

The real work starts with the add() method. We pass it an ADie object we want to add. We are using the PHP 8.1 feature that allows a default value to be a new object, in this case, a default six-sided ADie. Our user can add as many ADie as they want, and of any type of ADie.

We have also implemented the PHP interface Countable, which means we find out the number of ADie objects contained in our Dice object.

The final three methods perform actions on our Dice. We can roll them, get their values, or copies of the actual ADie objects themselves. This might be useful if we have Dice with more specific properties (which I will go into more detail in the next installment.)

One thing to note is while the ADie and Dice classes both have a roll() method, they are different and not related other than they perform the same function. Some developers might think this is a reason for inheritance, but it is not. In PHP land, you could implement a Roll interface if you needed to pass both Dice and ADie class objects into something that did not care what it was rolling, but that is a more advanced discussion.

You might be asking yourself why does the getDies() method clone the returned ADie objects? Quite simple actually. PHP objects are always passed by reference, meaning the same object is always used even when you "copy" them into an array, or pass them as a parameter to a method. The add() method also clones the ADie object. This means the original ADie the programmer added to the Dice collection can not be changed from the outside by holding on to the ADie object and calling the roll() method on the ADie object. Hmm, seems like we should test this!

## Test Those Dice!

```php
class DiceTest extends \PHPUnit\Framework\TestCase
  {
  public function testDefaultDice() : void
    {
    $dice = new Dice();
    $this->assertCount(0, $dice);
    $dice->add();
    $this->assertCount(1, $dice);
    $dice->add();
	$this->assertCount(2, $dice);
	$dice->add();
	$this->assertCount(3, $dice);
	$dice->add();
	$this->assertCount(4, $dice);
	$dice->add();
	$this->assertCount(5, $dice);
	$dice->roll();
	$values = $dice->values();
	$this->assertCount(5, $values);
	$dies = $dice->getDies();
	$this->assertCount(5, $dies);
	for($i = 0; $i < 5; ++$i)
	  {
	  $this->assertEquals($values[$i], $dies[$i]->value());
	  }
	}
public function testCustomDice() : void
  {
  $dice = new Dice();
  $this->assertCount(0, $dice);
  $sixDie = new ADie(6);
  $dice->add($sixDie);
  $this->assertCount(1, $dice);
  $eightDie = new ADie(8);
  $dice->add($eightDie);
  $this->assertCount(2, $dice);
  $twelveDie = new ADie(12);
  $dice->add($twelveDie);
  $this->assertCount(3, $dice);
  $sixteenDie = new ADie(16);
  $dice->add($sixteenDie);
  $this->assertCount(4, $dice);
  $eightteenDie = new ADie(18);
  $dice->add($eightteenDie);
  $this->assertCount(5, $dice);
  $dice->roll();
  $values = $dice->values();
  $this->assertCount(5, $values);
  $dies = $dice->getDies();
  $this->assertCount(5, $dies);
  $sideCount = [6, 8, 12, 16, 18];
  for($i = 0; $i < 5; ++$i)
	{
	$this->assertEquals($values[$i], $dies[$i]->value());
	$this->assertEquals($sideCount[$i], $dies[$i]->sides());
	}
  // roll our copies of the dies, then test to see if things have changed with the Dice copy
  $sixDie->roll();
  $eightDie->roll();
  $twelveDie->roll();
  $sixteenDie->roll();
  $eightteenDie->roll();
  $newValues = $dice->values();
  $this->assertCount(5, $newValues);
  $newDies = $dice->getDies();
  $this->assertCount(5, $newDies);
  for($i = 0; $i < 5; ++$i)
	{
	$this->assertEquals($values[$i], $newValues[$i]);
	$this->assertEquals($newDies[$i]->value(), $dies[$i]->value());
	$newDies[$i]->roll();	// roll and see if we can affect next test
	}
  $newValues = $dice->values();
  $this->assertCount(5, $newValues);
  $newDies = $dice->getDies();
  $this->assertCount(5, $newDies);
  for($i = 0; $i < 5; ++$i)
	{
	$this->assertEquals($values[$i], $newValues[$i]);
	$this->assertEquals($newDies[$i]->value(), $dies[$i]->value());
	}
  }
}
```

I will leave it to the reader to fully understand the tests for the Dice class, but look for the following:

* Default add() parameter
    
* count functionality
    
* Invariance of the Dice class even if the ADie objects that are added to it change
    

Fool around with the code and see what happens when you remove the clones from the add() and getDies() methods.

## Takeaways

Here is what I hope readers understand from the above:

* Object Oriented programming does not always mean inheritance.
    
* Objects allow you to hide your implementation. You can change how you do things without affecting your users, like a better random function.
    
* Always think about **ISA** or **HASA** before you start designing and writing code.
    
* Always write tests to confirm your objects work as expected.
    

## Next Time

We are going to talk about inheritance in the next installment. We can extend both the ADie and Dice classes to be more specific for specific use cases.