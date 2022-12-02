# Why I Don't Use USE

One of the most important things for any program to accomplish is to explain itself to the next developer, or even your future self. While a program has to work correctly, its next most important property is to document itself so the future you, or your successor, can figure out what it is doing and why. And since the human brain has to process the code, as well as the machine, it helps to make things as easy as possible for the brain to comprehend. And this means no unneeded levels of indirection.

Let's consider the following code:

```plaintext
$client = new Client($apiKey, $secret, $redirectUrl);
```

So what are we doing here? Well, I am creating a new client that will probably access an API. But what API am I using? No idea, unless I look up at the top of the file to figure out what use statement the former developer specified.

Now let's look at this code:

```plaintext
$client = new \PHPFUI\ConstantContact\Client($apiKey, $secret, $redirectUrl);
```

Now I know this relates to Constant Contact, and I will probably be using the Constant Contact API to get something I need. And I only have to look at this one line, and I know what is going on. I don't have to deal with any other Client classes.

## Reducing Cognitive Load

While modern development environments will resolve use statements and show you the actual FQN (Fully Qualified Name), you still have to hover over it, or otherwise look for it. If the FQN is right there, you don't need to know anything else to be productive with the code. It all has to do with limiting the cognitive load while you are trying to figure out what the code does, and since use statements are another level of indirection, it is just another thing you have to deal with.

## Faster runtime!

While the run time overhead of use statements may not be an overriding concern and will probably not affect the performance of your code, use statements still extract an overhead. Nothing is free and time is cumulative. It all adds up.

## Easier Refactoring

Often you want to refactor code. Extensive use of use statements just makes things harder to move around, as you always end up forgetting to move the appropriate use statements. Even worse, you may end up with a conflict, and not even realize it until a customer calls with an issue. Remember that Client? Oops, you are now using a different Client class!

## Always use FQN

Another style rule I enforce is always using the FQN even if the class is in the current namespace. This is the same as an implicit use. When you refactor code, you are just creating extra work and inviting the introduction of bugs into your code when you don't fully qualify things.

## And finally grep!

FQN are fully grep compatible! I don't know how many times a day I end up grepping things. The beauty of using FQN everywhere is you can easily find where something is used on the entire code base. With a use statement, you only know in which files something is used, but with an FQN, you can see where it was created, or static methods were called on the class. This gets you closer to the actual use of the class. Imaging trying to grep just Client. With grep, the more you specify, the more accurate your results are.

And there are 5 solid reasons not to use USE statements!