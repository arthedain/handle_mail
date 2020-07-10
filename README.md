````
php artisan vendor:publish --provider="Arthedain\HandleMail\ToolServiceProvider" --tag="default"
````

```$xslt
php artisan queue:table

.env
QUEUE_CONNECTION=database

php artisan migrate
```

````
"Name": "Name",
"Email": "Email",
"Status": "Status",
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
"Resend all emails": "Resend all emails",
"Request": "Request",
````
