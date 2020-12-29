Laravel Nova Handle-Mail
===
Laravel Nova Tool for managing sending mails from the site through the queue

Installation
---
```
composer require arthedain/handle-mail
```
Register tool in NovaServiceProvider

```
public function tools()
{
     new HandleMail
}
```

After registering publish default files
````
php artisan vendor:publish --provider="Arthedain\HandleMail\ToolServiceProvider" --tag="default"
````
> Or you can publish files by tag:
> * job
> * mail
> * view
> * script
> * config
> * migration

Then run the commands:
```$xslt
php artisan queue:table
php artisan queue:failed-table

php artisan migrate
```
----
#### Required 
Update .env:
```
QUEUE_CONNECTION=database
``` 
Usage
------
Enter emails in ``config/handle-mail.php`` to send mail from the site
```$xslt
'email' => [
    //
],
```

>You can skip this step and not use js file for async request in your project

Include published ``handle-mail.js`` file in your project files, or create your own file to send a request.
Add your custom form class to ``handle-mail.js`` file, or use default class ``form``.

```$xslt
<form class="form">
    <input type="text" name="email">   
...
```
<br>

Route for request  ```/handle-mail/send```. Route name ``handle-mail.send``

<br>

If you need to execute code before sending mail, you can change the path and call the method:
```$xslt
namespace Arthedain\HandleMail\Senders;

class MailSender
{
    public function send(Request $request, string $subject = 'Request')
```
<br>

Command for schedule:
````
$schedule->command('queue:work --stop-when-empty --queue=handle-mail')->everyFiveMinutes()
````
------------------

### View
After publish default files you can change mail template in ```resource/views/vendor/handle-mail/mail.blade.php```

------------------

### Telegram
The package includes tools for sending emails to Telegram.
To send letters to Telegram, you need to change the setting ``telegram`` in the file ``config\handle-mail`` 
First, you need to create a Telegram bot via @BotFather. After creating a bot, you need to add a token and chat ID in the ``.env`` file:
````
TELEGRAM_BOT_TOKEN=XXXX:XXXXXXXXXXXX 
TELEGRAM_CHAT_ID=XXXXXXXXXX
````

>You can use @userinfobot to get the ID.
>For private chats, the ID must be obtained through the url in the web version of the telegram: for example, the url `web.telegram.org/#/im?p=c123456789_XXXXXXXXXXXX`, you need to take the first part and add `-100`. The result should be `-100123456789`

### Spam filter
The package `spatie/laravel-honeypot` is used to filter spam. You can read the full documentation [here](https://github.com/spatie/laravel-honeypot).
To use the spam filter add `@honeypot`:
```
<form method="POST" action="/mail">
    @honeypot
    <input name="email" type="text">
</form>
```

In the published config file `config\honeypot`, replace the value `respond_to_spam_with`:
```
/*
 * This class is responsible for sending a response to requests that
 * are detected as being spammy. By default a blank page is shown.
 *
 * A valid responder is any class that implements
 * `Spatie\Honeypot\SpamResponder\SpamResponder`
 */
'respond_to_spam_with' => Arthedain\HandleMail\SpamFilter\HandlePageResponder::class
```
>Or execute the command: `php artisan vendor:publish --provider="Arthedain\HandleMail\ToolServiceProvider" --tag="config-honeypot" --force`

Then add `Spatie\Honeypot\ProtectAgainstSpam` middleware to the post route
```
Route::post('/send_message', 'Controller@sendMessage')->middleware(ProtectAgainstSpam::class);
```

### User history
User history allows you to save the history of the user's page visits before sending messages.

Activated in the config file `config\handle-mail`:
```
'history' => false,
```
To work with history, you can use the class `Arthedain\HandleMail\HistoryHandle\HandleMailHistory::class`, or create your own class, the handler must implement the interface `Arthedain\HandleMail\HistoryHandle\Interfaces\History::class`.
If you use your own handler class, you need to change the class in the config file `config\handle-mail`.
```
'history_class' => Arthedain\HandleMail\HistoryHandle\HandleMailHistory::class,
```

### Tool localization

Add this lines to your nova localization file:
````
"Name": "Name",
"Email": "Email",
"Status": "Status",
"status": "status",
"created_at": "created_at",
"Handle Mail": "Handle Mail",
"Failed": "Failed",
"New today": "New today",
"Per month": "Per month",
"The list is empty": "The list is empty",
"Mails": "Mails",
"Email deleted successfully": "Email deleted successfully",
"Error": "Error",
"Mail": "Mail",
"Failed mails": "Failed mails",
"Failed mail": "Failed mail"
"Resend all emails": "Resend all emails",
"Request": "Request",
"failed_at":"failed_at",
"exception":"exception",
"Send mail":"Send mail",
"Mail sent successfully": "Mail sent successfully",
"Delete email":"Delete email"
````
You can add more localization lines, they automatic update your keys in mail templates and in tool pages
