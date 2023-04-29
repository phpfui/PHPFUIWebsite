---
title: "PHP Inheritance Explained"
datePublished: Fri Apr 14 2023 20:34:29 GMT+0000 (Coordinated Universal Time)
cuid: clgh0cgnp00080ajrd67lea0a
slug: php-inheritance-explained
cover: https://cdn.hashnode.com/res/hashnode/image/stock/unsplash/CyuRKLT32vw/upload/fea633b9342b5dfa8b8279e0a7b8eaff.jpeg
tags: oop, php, inheritance, phpunit

---

In my [last article](https://blog.phpfui.com/php-object-oriented-programming), I explained OO (object oriented) programming does not necessitate inheritance. A common mistake among developers is to assume you need inheritance to do OO programming. But inheritance is an important concept if used correctly. This article will show some concrete examples.

## Monopoly Dice

If we were to model the board game Monopoly, we would certainly want some Dice. Monopoly dice are different from Yahtzee dice and certainly different from World of Warcraft dice. So let's model Monopoly dice. We can use our Dice class, but extend it a bit to make it more specific. First, we know we want the standard six-sided die, and second, we need two of them. We also might want to know if the dice have rolled doubles, as that makes a difference in Monopoly. And we want the total value of the two dice to compute how far we need to move.

```php
namespace Monopoly;
class Dice extends \Dice
  {
  public function __construct()
    {
    $this->add();
    $this->add();
  }
public function doubles() : bool
  {
  $values = $this->values();
  return $values[0] == $values[1];
  }
public function value() : int
  {
  $values = $this->values();
  return $values[0] + $values[1];  
  }
}
```

The first thing we do is declare an appropriate [namespace](https://blog.phpfui.com/php-namespace-best-practice).

Next, we construct our object with two default ADie classes, which is the six-sided die.

And then we implement the two methods we want, doubles() and value(). One could make an argument that the value() method should be in the base class, and that would not be wrong. But for this example, we will add it to this class. Notice we did not have to worry about the roll() method. It works exactly as it needs to, and we don't have to adjust its behavior by overriding it.

We have now successfully inherited the base Dice class to extend it for Monopoly. We used inheritance because a Monopoly\\Dice **is a** Dice.

One thing we did not implement in the Monopoly\\Dice class is going to jail. Remember, three doubles in a row lands you directly in jail without visiting the next property. Why not? Seems logical. But you have to understand that three doubles in a row is a rule of the game in Monopoly, and not a property of the dice. Doubles is a property of the dice, while going to jail is not. So we would implement going to jail when we model the game play and not the dice.

## Testing Random Behavior

While we have only added two trivial methods for this class, we should test it to make sure it does what we think it should do. The problem is we can't set the values of a Dice object. We made sure of this in the last article. So how do we know if doubles() or even the value() method will work? They look simple enough.

The answer is to use some probability in our test of rolling doubles. If we roll the dice 100 times, I am sure we will get a double, probably more! So let's write the test:

```php
namespace Test\Monopoly;
class DiceTest extends \PHPUnit\Framework\TestCase
  {
  public function testDoublesDice() : void
    {
    $dice = new \Monopoly\Dice();
    $doubleCount = 0;
    for($i = 0; $i < 100; ++$i)
      {
      $dice->roll();
      $values = $dice->values();
      $value = $values[0] + $values[1];
      $this->assertEquals($value, $dice->value());
      if ($dice->doubles())
        {
        $this->assertEquals($values[0], $values[1]);
        ++$doubleCount;
        }
      else
        {
        $this->assertNotEquals($values[0], $values[1]);
        }
      }
    $this->assertGreaterThan(0, $doubleCount);
    }
  }
```

Notice we are testing each roll for value(). Might as well, as we need to get the values array for the rest of the test. Then, if we have doubles, we check to make sure the values are equal, if it is not a double, then confirm the values are different.

Only one more thing to test, which is, did we get any doubles? So we count the doubles and make sure we have at least one.

## Modeling Dice Images

Our standard ADie class does not deal with images of the die, but what if we wanted to show the die to our user? How would we implement this? First, we need to decide how we are going to show the die to the user. We could return a simple image, or we could do it in CSS. There are many [3D](https://codepen.io/SteveJRobertson/pen/zxEwrK) dice models out there, but we will try a more simple [2D](https://dev.to/ekeijl/creating-dice-using-css-grid-j4) representation.

We want to get a face of the current value. Let's go to the code:

```php
namespace Monopoly;
class ImageDie extends \ADie
  {
  public function getFace() : \PHPFUI\HTML5Element
    {
    $face = new \PHPFUI\HTML5Element('div');
    $face->addClass('face');
    $value = $this->value();
    while ($value--)
      {
      $face->add('<span class="pip"></span>');
      }
    return $face;
    }
  }
```

As with any HTML page, we need to add some CSS.

```css
.face {
	display: grid;
	grid-template-areas:
		"a . c"
		"e g f"
		"d . b";
	flex: 0 0 auto;
	margin: 16px;
	padding: 10px;
	width: 104px;
	height: 104px;
	background-color: #e7e7e7;
	box-shadow: inset 0 5px white, inset 0 -5px #bbb, inset 5px 0 #d7d7d7, inset -5px 0 #d7d7d7;
	border-radius: 10%;
}
.pip {
	display: block;
	align-self: center;
	justify-self: center;
	width: 24px;
	height: 24px;
	border-radius: 50%;
	background-color: #333;
	box-shadow: inset 0 3px #111, inset 0 -3px #555;
}
.pip:nth-child(2) {grid-area: b;}
.pip:nth-child(3) {grid-area: c;}
.pip:nth-child(4) {grid-area: d;}
.pip:nth-child(5) {grid-area: e;}
.pip:nth-child(6) {grid-area: f;}
.pip:nth-child(odd):last-child {grid-area: g;}
```

Now we can write a simple web page that will show a random roll of all six die on each load.

```php
$page = new \PHPFUI\VanillaPage();
// add the above css to the page
$page->addCSS('.face {
	display: grid;
	grid-template-areas:
		"a . c"
		"e g f"
		"d . b";
	flex: 0 0 auto;
	margin: 16px;
	padding: 10px;
	width: 104px;
	height: 104px;
	background-color: #e7e7e7;
	box-shadow: inset 0 5px white, inset 0 -5px #bbb, inset 5px 0 #d7d7d7, inset -5px 0 #d7d7d7;
	border-radius: 10%;
}
.pip {
	display: block;
	align-self: center;
	justify-self: center;
	width: 24px;
	height: 24px;
	border-radius: 50%;
	background-color: #333;
	box-shadow: inset 0 3px #111, inset 0 -3px #555;
}
.pip:nth-child(2) {grid-area: b;}
.pip:nth-child(3) {grid-area: c;}
.pip:nth-child(4) {grid-area: d;}
.pip:nth-child(5) {grid-area: e;}
.pip:nth-child(6) {grid-area: f;}
.pip:nth-child(odd):last-child {grid-area: g;}');

$faces = [];
$imageDie = new ImageDie();
// make sure we have a face for every possible value
while (count($faces) < 6)
	{
	$faces[$imageDie->value()] = $imageDie->getFace();
	$imageDie->roll();
	}
// add to page and display
foreach ($faces as $face)
	{
	$page->add($face);
	}
echo $page;
```

We now have an ImageDie class that we could make much fancier, but this is a simple example.

## How to Test HTML and CSS

While this is another fairly trivial class, we still should test it. But how? The code outputs HTML as a string. How do we know it is valid HTML? We did write a program (above) to see that it worked for our own eyes, but it would be nice to know if a future change invalidates the HTML for some reason. I had this problem before, so I write a solution for it! It is called [phpfui/html-unit-tester](https://packagist.org/packages/phpfui/html-unit-tester) and it uses the W3C Java validation server. Check out the installation instructions if you want to follow along at home.

```php
namespace Tests\Monopoly;

class ImageDieTest extends \PHPFUI\HTMLUnitTester\Extensions
  {
  public function testImageDieFaces() : void
    {
    $page = new \PHPFUI\VanillaPage();
    $page->setPageName('ImageDie Test');
    $css = '.face {
      display: grid;
      grid-template-areas:
          "a . c"
          "e g f"
          "d . b";
      flex: 0 0 auto;
      margin: 16px;
      padding: 10px;
      width: 104px;
      height: 104px;
      background-color: #e7e7e7;
      box-shadow: inset 0 5px white, inset 0 -5px #bbb, inset 5px 0 #d7d7d7, inset -5px 0 #d7d7d7;
      border-radius: 10%;
    }
    .pip {
      display: block;
      align-self: center;
      justify-self: center;
      width: 24px;
      height: 24px;
      border-radius: 50%;
      background-color: #333;
      box-shadow: inset 0 3px #111, inset 0 -3px #555;
    }
    .pip:nth-child(2) {grid-area: b;}
    .pip:nth-child(3) {grid-area: c;}
    .pip:nth-child(4) {grid-area: d;}
    .pip:nth-child(5) {grid-area: e;}
    .pip:nth-child(6) {grid-area: f;}
    .pip:nth-child(odd):last-child {grid-area: g;}';

    $this->assertNotWarningCss($css);
    $this->assertValidCss($css);
    $page->addCSS($css);
    $faces = [];
    $imageDie = new \Monopoly\ImageDie();
    // make sure we have a face for every possible value
    while (\count($faces) < 6)
      {
      $face = (string)$imageDie->getFace();
      $this->assertValidHtml($face);
      $faces[$imageDie->value()] = $face;
      $imageDie->roll();
      }
    // add to page and display
    foreach ($faces as $face)
      {
      $page->add($face);
      }
    $html = (string)$page;
    $this->assertValidHtmlPage($html);
    }
  }
```

Notice we are testing the CSS to see if it is valid and has no warnings. We also test each face, then the entire page.

## Other Examples

We could add a name() method to name specific die, or we could add a color, the possibilities are only limited by your imagination and needs.

What we have done with MonopolyDice is created a concrete class that solves our application's needs. We don't have to worry if someone else can use it. We are not writing a generic library for all PHP users. We could easily do a World of Warcraft dice class. In this example, we probably want to get specific groups of die, so we could add more specific methods to organize the dice. The point is, we don't have to worry about rolling or displaying individual dies. The class does that for us at any level we want.

## Follow Along At Home

I am posting all the code in this blog to GitHub so you can experiment with the code yourself.

## Takeaways

* Inheritance does not have to be complicated. But it should follow **ISA** relationships.
    
* Inheritance does not prevent you from using composition. Our Dice class uses composition (contains instances of the ADie class). \\Monopoly\\Dice uses inheritance.
    
* You can add additional methods and properties to child classes to make them more specific to your needs. Not everything needs to be in the parent class.
    
* Don't worry about use cases you will not need, write classes for your needs.