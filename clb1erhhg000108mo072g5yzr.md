# Make Exceptions EXCEPTIONAL!

PHP, like most modern languages, has exceptions. While exceptions are extremely useful, they are also ripe for abuse.

No matter what language you use, exceptions are not free. The compiler or interpreter has to perform extra work to account for exceptions. Some languages de-prioritize runtime efficiency when running exception code. Exceptions also separate the cause of the problem from where the problem is eventually solved.

### Exceptions are the modern GOTO

In some senses, exceptions are the modern **GOTO**. The problem with the GOTO was never the **GOTO** statement itself. That was always very clear in the code, as it tells you exactly where it is going! The problem with the **GOTO** statement is the *come from* statement. Wait, you have never heard of the *come from* statement? You might know it as a label. The problem with the label is "how did you get there?" The same problem with exceptions! You end up in a catch block but have no idea of how you got there without examining the entire stack.

### Think of Exceptions as EXCEPTIONAL!

Programmers are always going to have to deal with exceptions. The world is not perfect or infinite. Servers are down, disks fill up, databases have errors. Failures happen. These are all valid exceptions. Something that is **EXCEPTIONAL** as in it is not expected and does not normally happen. Things you might expect to happen, but normally don't are **NOT** exceptional and should not be dealt with as exceptions.

### Examples of REAL Exceptions

*   Can't connect to your database. Definitely an issue. Alert the DEV-OPS team and bail!
    
*   Can't connect to a server that is normally up. Log it and retry or fail gracefully.
    
*   Disk error. Another DEV-OPS issue, but you may be able to fail gracefully.
    
*   Type error. This should not happen, but the developer should know about it. Log it and see if you can fail gracefully.
    
*   Run time errors from your language. Log it and see if you can fail gracefully.
    
*   SQL syntax error. Log it and bail to let the developer know.
    

### Examples of NON-Exceptions!

*   User enters the wrong password. People make typos. Happens all the time. Not an exception.
    
*   An API returns a non-200 status code. Hey, the documentation explicitly states other status codes are possible. Not an exception.
    
*   Database queries that don't return a record. Of course, a particular record may not be in the database. Not normally an exception.
    
*   Any input from a user. Users do stupid things. Not an exception.
    

I have seen all of the above examples in production code and in packages from Packagist.org. This is simply laziness of the developer to punt rather than deal with things when they happen. This laziness costs you in multiple ways. Exceptions have overhead in runtime and cognitive load for you and the next developer. The further away from the source of the problem you end up, the harder it is to intelligently deal with the problem.

### Dealing with forced exceptions

Often you don't have control over when exceptions are thrown, for example in third-party source code. So you have to deal with exceptions used for logic reasons rather than unavoidable failures. The best way to do this is to handle the exception as close to the source of the throw as possible. Try to solve the problem locally when possible. If you end up having to rethrow the exception, consider just not catching it to begin with and leave the handling to something further up, as you are going to have to deal with it later if you can't deal with it now. At the highest level of your code, you need to log the exception and exit with something that makes sense to the user. This is often an error page unfortunately. Ideally, you don't show the exception call stack to the user, as this is an information leak that could lead to a breach of your website. I can't count the number of Java stack dumps I have had to endure when something goes sideways on public websites. Simply not acceptable and the direct result of not dealing with exceptions correctly.

### Your own exceptions

If you can control where exceptions are thrown, you might want to rethink the need to need for the exception. I generally try to keep exceptions out of my code, as it just increases the cognitive load for you and subsequent maintainers.

The one exception to no exceptions is validating developer code. A great example of this is validating parameters to methods, object consistency, invalid object access, valid SQL, or anything else that is the developer's responsibility to get right. Let them know early on they made a mistake. They will thank you in the long run.

One area I absolutely won't tolerate exceptions is user input. User data is often crazy, but you need to deal with crazy and let the user know of the issues. A rational error report is better than a random exception you don't expect, might not be something you want to expose to the user.

### The Simple Exception Rule

Make exceptions exceptional. The rest will flow from this simple rule.