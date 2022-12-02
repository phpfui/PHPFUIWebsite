# PHP Error Logging To Slack

In my last post, I covered why you want a clean error log. But the problem is, what if your error log is not visible to the team? An inaccessible error log is not doing anyone any good. Need to SSH into a server? Too much work. Only available in the office? Not available when you might need it.

### Slack to the Rescue

You probably use Slack (or equivalent) already. Slack has a nice client that runs right on your phone. And lucky for us, someone already wrote a [PHP Slack client](https://packagist.org/packages/alek13/slack). So we can create a channel in Slack and send all the errors and warnings directly into the Slack channel. Bingo, error log on your phone, assessable from anywhere at any time.

### Slack Setup

You will need to create a [Slack Incoming Webhook](https://api.slack.com/messaging/webhooks). You should probably create a dedicated Slack channel for the error log, appropriately named. I will leave the exact Slack setup as an exercise for the reader. I set this up years ago and have not looked at it since, so I have no idea what is involved at this point. I just know it is possible to do. Google will turn up something quickly.

### PHP Code

The PHP code for this is fairly simple. You can run it with just a few lines of code:

```php
$guzzle = new \GuzzleHttp\Client(['verify' => false, 'http_errors' => false]);
$client = new \Maknz\Slack\Client($hook, guzzle:$guzzle);
$client->send("{$hostName}\n{$text}");
```

Of course, this is a simple, but a usable example. I currently use it with a cron job that reads the error file, does minor formatting and sends it off to Slack. You can get more elaborate if you wish, but with error logging, you are looking for reliable logging, so keep it simple. Making it more complex runs the risk that the error logging subsystem has an error and fails to report any errors at all!

### One Last Thing

How do you know if your code has no errors, or that the error log is down? They both look the same: empty. The answer is you have to have a way to test the error reporting mechanism. I add some superuser-only accessible code where I can execute deliberate errors and see if my error logging pipeline is operational. I will leave PHP error generation to the reader.

And that is how to make a highly available and simple PHP error log. Accessible from everywhere. What you decide to do with it is up to you.