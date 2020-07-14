Laravel Nova Handle-Mail
===
Laravel Nova Tool for managing sending mails from the site through the queue

Installation
---
```
composer require arthedain/handle-mail
```
After installation publish default files
````
php artisan vendor:publish --provider="ArthedainHandleMail\ToolServiceProvider" --tag="default"
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
Enter emails in ``config/handle_mail.php`` to send mail from the site
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
namespace Arthedain\HandleMail\Http\Controllers\User;

class HandleMailController
{
    /**
     * @param Request $request
     * @param string $subject
     * @param null $callback
     * @return \Illuminate\Http\Response
     */
    public function post(Request $request, string $subject = 'Request', $callback = null)
```
<br>

Command for schedule:
````
$schedule->command('queue:work --stop-when-empty --queue=handle-mail')->everyFiveMinutes()
````
------------------

###View
After publish default files you can change mail template in ```resource/views/vendor/handle-mail/mail.blade.php```

------------------



###Tool localization

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
