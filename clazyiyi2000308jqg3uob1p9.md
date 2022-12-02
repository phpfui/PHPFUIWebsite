# Your First Open Source Contribution

As a PHP package maintainer, I often get new users submitting their first Pull Request (PR).  This is completely awesome and the best part of being in the open source community. And often the PR shows it is a first PR.

I remember my first experience with Open Source.  I had discovered Composer and Packagist.org and it was easy enough to add a package into my app.  But soon after, I discovered an issue with the package.  It may just be a warning message on the latest version of PHP, an actual bug that needs to be fixed, or simply an update to the documentation to make it easier for other developers to understand.  But then I was stumped. How do I even submit a PR.  I had no idea about how anything worked.  So with that in mind, I present everything you need to know about how to submit an update to an Open Source PHP package.

### Identify The Issue
Obviously you need to figure out the issue and how to fix it before you attempt anything.  The first thing to do is to look at the outstanding PR's on the project to see if your issue is already fixed.  Go to Packagist.org, find your package, then click on the GitHub link on the top right.  Look through the Pull Requests and Issues tabs to see if you can find your problem.  If you find a PR that solves your issue, post a comment that this affects you and you would like to see it merged.  You can also pull that specific branch into your project and confirm it works.  If you have confirmed the PR fixes the problem, you should mention that in the comment.

If your problem is listed in the Issues section, there may be a suggested fix.  See if that solves your problem.  If not, time for you to fix the problem.

### Create a GitHub account
If you don't already have a GitHub account, you will need to [create one](https://github.com/signup).

### Fork the repo
![image.png](https://cdn.hashnode.com/res/hashnode/image/upload/v1669580122330/mNtbspGJg.png align="left")
Forking the repo means you are creating a clone of the repo in your personal account.  You can't push changes directly to a repo you don't own, but you can push changes to a repo you own.

### Clone your fork to your local machine
You can more easily work with a locally copy of the repo on your machine.
![image.png](https://cdn.hashnode.com/res/hashnode/image/upload/v1669580210550/JqLvKO2L9.png align="left")
You want to use SSH or GitHub CLI.  If using SSH, hit the copy button, then type "git clone " and hit paste at a command line in the directory you want to contain the cloned repo.

### Create a branch for your fix
```
git checkout -b ＜branch-name＞
```
This is a very important step.  You should not commit anything to the main branch of a repo where you are not a maintainer.  A good branch name indicates what the PR will fix.  It could be WarningFix, ErrorOnUpload or anything else that makes sense to you.

### Composer Install and run tests
```
composer install
vendor/bin/phpunit
```
Do a composer install command and run all tests.  Often packages unit tests are broken.  Installing composer dependencies and running tests before changing a line of code will help you know if your fix broke something or if it came broken.  Broken tests should be investigated and resolved before you proceed.  Often it is your configuration that is wrong, but sometimes the package is at fault.  You need to resolve the former, while the later may need a separate PR to fix.  In any case, know the package's base line.

### Add a unit test to confirm your fix will work
Add a unit test that demonstrates the issue you are fixing and make sure it fails. There may be multiple ways for it to fail, see if you can find other paths to the failure and test those as well.

### Fix the code
Now fix the code.  Make sure to follow all coding conventions specified by the maintainers.  Often code style and linting can be automated.  Make sure you run any configured tools like [PHPStan](https://phpstan.org/), [PHPCSFixer](https://github.com/PHP-CS-Fixer/PHP-CS-Fixer) or others.  They should all be installed by composer.  Check [composer.json require-dev](https://getcomposer.org/doc/03-cli.md) section for hints on what is installed if it is not documented.

### Run tests for all PHP versions supported by the package
Often a package will support multiple versions of PHP.  You will need to test them all.  I have batch / script files that will run [PHPUnit](https://phpunit.de/getting-started/phpunit-9.html) on different version of PHP.  So I might type **phpunit71** to test an older version of PHP that I no longer use. Just running PHPUnit will only test the version of PHP you have currently installed.

### Make sure your fix works for you
Run your fixed code yourself and make sure it works for you.

### Push your fixed branch
```
git push
```
This will update the repo in your GitHub account.

### Add a PR to the original repo you forked from
Go to the original repo on GitHub.  Under the Code section, you should see a prompt to add a Pull Request for your just pushed branch.

Create the Pull Request.  Give it a good title and description.  It helps to describe the problem and your solution.  If you had to modify other things in the package to get things to work, detail why you made the change.

### Work with the maintainer to get your PR approved
Often the maintainer will have questions about the reasons for the changes.  Explain them to the best of your ability.  If they are requesting changes, make them to your branch on your local machine.  Repeat the code and unit tests you did before and push again. GitHub will automatically update the pull request to include your latest changes.

### Once approved, delete your branch, merge the original into your main branch
This step has mostly been automated by and been made much easier by GitHub.  Go to GitHub for your copy of the repo.  In the Code tab, you should see that the original repo is ahead of your copy.  Merge it into your repo.  This will keep your cloned repo in sync with the original repo.

Then switch to another branch (normally main), pull it to get the latest changes, and finally, delete your local branch:
```
git checkout main (or other branch)
git pull
git branch --delete <branch-name>
```

### Run composer update!
Congratulations, you are now an Open Source contributor.  Bask in your glory of slaying a bug!