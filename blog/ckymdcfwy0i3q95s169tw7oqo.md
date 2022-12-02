# Managing Supply Chain Risk

I was going to originally title this post **"Eliminating Supply Chain Risk"**, but then I thought, I can probably only eliminate risks I know about. Something about [unknown unknowns](https://en.wikipedia.org/wiki/There_are_known_knowns).

So what risks can we pretty much eliminate from our source code supply chains?  Basically any supply chain that provides full source code. While it is not a completely trivial undertaking to remove most of the risk, it is doable and should only have a small cost moving forward.  In case you missed it, you might want to take a look at the supply chain attack vectors I identified in my [previous post](https://blog.phpfui.com/the-attack-of-the-50-mile-wide-open-source-supply-chain).

There are basically two solutions that can be used to secure our supply chain.  One is for script based languages that don't use binary (or compressed / obfuscated source) files.  PHP, Ruby, Python and various other languages fall into this category and this is the simplest supply chain to secure.

The other category is for languages such as C# and Java, and minified JavaScript packages, that deliver binary or human unreadable source.

Lets cover the former case first, as the techniques used will be applied to the later problem as well.

## Part 1

### Check In All Source into git!
This is a critical step.  Any source you deploy, you need to have in version control.  Now I know what you are saying, "I use XYZ package manager, and it does all that work for me". But this is EXACTLY what causes the **50 mile wide open source supply chain vulnerability** in the first place. Package managers are all about delivering a collection of the latest source code that is compatible with your system. While some packages exist to [scan for known issues](https://packagist.org/packages/roave/security-advisories), they can't always catch everything.

### Check in ONLY code needed for a release
Don't check in unit testing, code formatting, or other development side code.  There is no reason to deploy this code, so it should definitely not be in a release. You could make an argument that this code does run on your machine, and presents a security vulnerability, but development tools tend to come from trusted sources.  But go with your gut on this if you want.

### Organize the Third Party Code in One Location
In PHP land, I like to assume the project root is also the namespace root, but feel free to put it anywhere.  A single directory of all third party code makes it much simpler to see what changes after a dependency update for all packages.

### Peruse All Third Party Libraries
OK, here is the huge amount of work that this method involves. You need to closely peruse ALL the source you are using.  The good thing, is you will only have to do this once.  If you are in a larger organization, you can split this up among the team, or have a organization approved package list where someone has previously investigated the package.  This is a critical step.  Failure to do this correctly can lead to trouble. You are looking for access to third party resources such as files, end points, and generally anything you can't understand by looking at it for a few seconds. Red flags are IO statements of any kind. You can generally breeze through most of the code, as it generally deals with manipulating things it should be responsible for.

### On Going Maintenance
Once you have closely perused the code, it is just a matter of taking a look at any new or changed code introduced after each dependency update.  Since you have all the open source code now in your version control system, you can now easily see any additions, changes or subtractions. A trusted senior member of your team should be responsible for reviewing all dependency updates.  This should be done a regular basis and at least once per release cycle.

### Done!
And there you have the solution to preventing supply chain attacks for open source projects that don't deploy binaries.  This will work for any human readable code for scripting or compiled languages where you build everything yourself.

## Part 2

### Securing Binary Deliverables
Basically, you can't solve this problem! You would have to trust the delivered binary is a compiled version of the source code provided with the package.  See [You're running untrusted code!](https://frankel.hashnode.dev/running-untrusted-code) for exactly why this can't be done.

### So What To Do?
You need to build all binaries from scratch yourself! This is the only solution. You need to apply all the steps outlined above in Part 1, then do a final step of building the code locally. While this may seem extreme, this is THE ONLY WAY you can guarantee the source you see is correctly represented in a binary you are going to deploy.  This applies to both compiled languages and obfuscated code such as minimized JavaScript.

While I will leave the details of how to do this up to the skills of the reader, I will offer a couple of solutions the industry must supply to close the **50 mile wide open source supply chain vulnerability**.  So here goes:

1. For all Microsoft languages delivering binaries, Microsoft needs to have these built in the cloud and then signed by Microsoft.  Signatures will need to be verified at install time.  This will solve the problem, as the source code can be verified to be correct. Microsoft being a trusted entity, can vouch for the built binaries.  We already do unit testing of uploaded packages.  They can also be built and signed as well. Microsoft needs to shoulder this expense, as they are the reason we are distributing binaries in the first place.
2. Oracle needs to do the same for Java binaries being delivered as well.  Same issue, your mess, your responsibility.
3. Another possibility is to set up build standards for open source libraries that would allow the end user developer to do the build locally. For example, Visual Studio could simply build all dependent packages used in a solution. This might be a better solution for Microsoft and would avoid a massive build machine in the sky for them (although one could argue a central build machine is more ecologically sound than multi-millions of local builds).

### And That is a Wrap!
So there is the solution to the **50 mile wide open source supply chain vulnerability**. It does require some work on the side of the developer, but not a huge cost. Plus it gives you some visibility into how the sausage is made, and you may decide a specific package is just not for you.

I have been practicing this for years and it works well with very little ongoing work.

Hope this helps someone avoid a supply chain attack.
