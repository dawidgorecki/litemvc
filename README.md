# LiteMVC PHP framework

This is a simple MVC framework for PHP 7.0.0 and later.

## Requirements

- PHP 7.0.0+
- MySQL/PostgreSQL
- mod_rewrite activated

## Usage

1. Install LiteMVC framework on your machine.
1. Run `composer update` to install the project dependencies.
1. Enter your configuration data in a specified files.
1. Configure your web server.
1. Add routes, create controllers, views and models.

## Installation

There are a few ways to install this framework.

- Use `Composer`:

```
{
    ...
    "require": {
        "dawidgorecki/litemvc": "1.*"
    }
}
```

- Download the framework directly. 
- Clone the repository.

## Configuration

Configuration files are stored in the `Application/Configs` directory. Default settings include database connection setting, SMTP configuration and some others. You can access the settings in your code like this: `Config::get('DB_HOST')`. Also you can add your own configuration settings in here.

For development environment, file [config-devel.php](Application/Configs/config-devel.php) is used. File [config-production.php](Application/Configs/config-production.php) is used on production environment. 

To change environment add one of the following instruction in [bootstrap.php](Application/bootstrap.php) file.

```php
System::setEnvironment(System::ENV_DEVELOPMENT);
System::setEnvironment(System::ENV_PRODUCTION);
```

## Web server configuration

Configure your web server to have the `Public` folder as the web root. Also add or update `ServerAdmin` variable in vhost configuration file. This will be used on the error pages.

## Routing

The [Router](Application/Libraries/Http/Router.php) translates URLs into controllers and actions. Routes are added in the [routes.php](Application/Configs/routes.php) file in the `Application/Configs` directory.

Routes are added with the `add` method. You can add fixed URL routes, and specify the controller and action:

```php
$router->add("", "Page", "view");
$router->add("pages/checkout", "Page", "checkout");
```

Or you can add route variables, like this:

```php
$router->add("user/edit/{id}", "User", "editUser");
```

You can specify any parameter you like within curly braces.

## Controllers

Controllers are stored in the `Application/Controllers` folder. Controllers are classes that extend the [Controller.php](Application/Libraries/Core/Controller.php) class, and need to be in the `Controllers` namespace. You can put any controller in subdirectory, but then you need to specify the namespace when adding route for these controller.

Controller has two special methods executed before and after any other actions:

```php
public function before()
{
    // e.g. checking authentication
}

public function after() 
{
    // do something
}
```

Getting model and view:

```php
$model = $this->getModel();
$view = $this->getView();
```

Model with the same name as controller is loaded automatically. You can load another models:

```php
$userModel = $this->loadModel("User");
```

## Views

Views are used to display information (usually HTML). View files are in the `Application/Views` folder and should be a Smarty template file (*.tpl). You can find some examples with bootstrap components in `Application/Views` dir. 

Rendering view:

```php
public function error500()
{
    $this->getView()->render('Templates/Errors/error500', ['serverAdmin' => getenv('SERVER_ADMIN')]);
}
```

Getting view as PDF file:

```php
$this->getView()->getPDF('file_name_without_extension', 'viewName');
```

You can use View static methods to check witch controller and action is active:

```php
\Libraries\Core\View::checkForActive('controller@action');
```

## Models

Models are used to get and store data in your application. Models extend the [Model.php](Application/Libraries/Core/Model.php) class and use PDO to access the database. They're stored in the `Application/Models` folder.

Example of database usage:

```php
$db = $this->getDB();

// Prepare a statement for execution 
$db->prepare("SELECT title FROM pages WHERE id = :id LIMIT 1");

// Bind a value to a parameter
$db->bind("id", $id);

// Execute a prepared statement and return result set
return $db->executeAndFetch();
```

## Captcha

You can create and add captcha image to the page by using this code:

```html
<img id="captcha" src="{\Libraries\Http\Request::getSiteUrl()}/captcha">
```
Generated phrase will be stored in the session variable `captcha`. You can change some settings in the [CaptchaController.php](Application/Controllers/Helpers/CaptchaController.php) file.

To reload captcha use this code:

```html
<a href="#" onclick="document.getElementById('captcha').src = '/captcha'; return false">Reload Captcha</a> 
```

You can compare the phrase with user input:

```php
if (!CaptchaUtils::checkCaptcha($userInput)) {
    // wrong captcha code
} else {
    // code ok
}
```

## Emails

To send email message use this code. Be sure you are changed SMTP configuration in config file.

```php
$mailer = new Libraries\Core\Mail();
$mailer->addRecipient('john.doe@example.com', 'John Doe');
$mailer->addContent('Subject', 'My message');

if ($mailer->sendMessage('peter@example.com', 'Peter Doe')) {
    // message was send
} else {
    // error
    die($mailer->getError());
}
```

## Errors

Error Views are stored in `Application/Views/Templates/Errors` folder.

## Dependencies

"smarty/smarty": "~3.1"  
"phpmailer/phpmailer": "~6.0"  
"spipu/html2pdf": "^5.1"  
"gregwar/captcha": "1.*"  

## License

Licensed under the MIT license. (http://opensource.org/licenses/MIT)