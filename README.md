# Sippy

A lightweight, easy to use PHP Framework for building websites and web apps. SippyV2 is now available with an updated framework, https://github.com/trafficinc/sippyV2.

# Documentation

Sippy’s architecture bares striking resemblance to  Codeigniter, so we call it a lightweight PHP framework. However, remember that because Sippy is lightweight, it does not include a lot of the functionality that comes with Codeigniter.  Maybe we can add "plug-n-play" functionality via plug-ins, controllers, and libraries. To use remove the "sample" from config file in Application/config/sample.config.php so it is Application/config/config.php and fill in your configuration data.

# Model-View-Controller

Sippy is based on the Model-View-Controller development pattern.

# Folder Structure

Your application specific files go in the "application" folder (you don't need to touch the system folder). Inside the application folder there are folders for all of the specific application entities:

config
controllers
helpers
logs
models
plugins
views

When Sippy loads files it assumes they are in the corresponding folders. So make sure you place your files in the correct folders.

We encourage you to use the "assets" folder in the root to store you static resource files (CSS, JS etc) however you can put them anywhere. You can also use the `site_url()` function to help include files in your HTML or use `site_url('main/index')` to go to the `http://www.yoursite.com/main/index` page. For example:
```html
<link rel="stylesheet" href="<?php echo site_url(); ?>assets/css/style.css" type="text/css" media="screen" />
```
# Naming Conventions

All classes in Sippy use PascalCase naming. The associated file names must be the same except all lower case. So for example the class MainClass would have the filename mainclass.php. Underscores in classes must be included in file names as well.

# URL Structure

By default, URLs in Sippy are designed to be search-engine and human friendly. Rather than using the standard "query string" approach to URLs that is synonymous with dynamic systems, Sippy uses a segment-based approach:

`example.com/class/function/param`
By default index.php is hidden in the URL. This is done using the .htaccess file in the root directory.

# Authentication System 

Just put files into your project for easy authentication: https://github.com/trafficinc/sippy-auth

## Controllers

Controllers are the driving force of a Sippy application. As you can see from the URL structure, segments of the URL are mapped to a class and function. These classes are controllers stored in the "application/controller" directory. So for example the URL...

`example.com/main/login`
...would map to the following Controller with the filename main.php:

```php
<?php

class Main extends Sippy_controller {

    function index() {
        // This is the default function (i.e. no function is set in the URL)
    }

    function login() {
        echo 'Hello World!';
    }
}
```

...and the output would be "Hello World!".

The default controller and error controller can be set in application/config/config.php

Note that if you need to declare a constructor you must also call the parent constructor like:
```php
<?php

class Example extends Sippy_controller {

    public function __construct()
    {
        parent::__construct();
        // Your own constructor code
    }

}

?>
```
There are several helper functions that can also be used in controllers. Most of these functions take the parameter $name of the corresponding class:

* Model($name) - Load a model
* View($name) - Load a view
* Plugin($name) - Load a plugin
* Helper($name) - Load a helper
* redirect($location) - Redirect to a page without having to include the base URL. E.g.
* $this->redirect('some_class/some_function');
* ex. $this->redirect('some_class/some_function');

Log Errors and Debugging information
* In your config file, you must enable logging; set to TRUE.

Then you can add this code to your controller for debugging.

* Errors: `log_message(‘error’,’Your log message‘);`
* Debugging: `log_message(‘debug’,’Your log message‘);` 

Example Controller validation & CSRF token protection & Flash Error/Success Messages:
#controller
        `require SYSTEM_DIR.'/Validation.php';`
        `protected $validation;`
        `in __constructor: $this->validation = new Validation;`
        ----
        $data['messSuccess'] = $this->flash->message('success');
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if ($_POST['csrf'] === $_SESSION['csrf_token']) {
            
                $validator = $this->validation->go($_POST, [
                    'email' => 'required|min:5',
                    'password' => 'required',
                ]);
                
                if (count($validator) > 0) {
                    $data['errors'] = $validator;
                } else {
                  
                  // ** Do Stuff **
                  
                  $this->flash->message('success','Your flash message here');
                  $this->redirect('auth/login');
                }
              }
          }

#view

                <h1>Login</h1>

                <?php
                if (isset($messSuccess)) {
                    $this->success_block($messSuccess);
                }
                if (isset($errors)) {
                    $this->error_block($errors);
                }
                ?>

                <form method="post" action="<?php echo site_url('auth/login'); ?>">
                    <input type="hidden" name="csrf" value="<?php echo $this->security->generate_csrf_token(); ?>"/>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="Email">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" name="password" class="form-control" id="password" placeholder="Password">
                    </div>
                    <button type="submit" class="btn btn-default">Login</button>
                </form>
                

## Views

In Sippy a view is simply a web page. They can contain everything a normal web page would include. Views are almost always loaded by Controllers. So for example if you had a view called main_view.php that contained the following HTML:
```php
<html>
<head>
<title>My Site</title>
</head>
<body>
    <h1>Welcome to my Site!</h1>
</body>
</html>
... you would load it in a controller by doing the following:
// Controller file...
<?php

class Main extends Sippy_controller {
  
    function index()
    {
        $template = $this->View('main_view');
        $template->render();
    }
    
}
```

The View class has a helper function called `set($key, $val)` that allows you to pass variables from the Controller to the View.

```php
$template = $this->View('main_view');
$template->set('someval', 17);
$template->render();
```
...then in the view you could do:

`<?php echo $someval; ?>`

...and the output would be 17. Any kind of PHP variable can be passed to a view in this way: arrays, etc.

**OR**

In the controller you can call your views with data that will then be available in the view. This can be achieved to ways. In controller...

```php
$header = array('title'=>'My Title','descr'=>'Login Page','keywords'=>'login,page,mysample');

$template = $this->View('main/index',$d);
```

In the view, these array items can be accessed like so...
```
<?php echo $title; ?>
```
Which will show the text "My Title", and so on for the rest of the array.

The **preferred** way to access data in views is to name the data array and access it in the controller like so...

```php
$data['body'] = "Hello World";
$data['heading'] = array('title'=>'My Title','descr'=>'Login Page','keywords'=>'login,page,mysample');

$template = $this->View('main/index',$data);
```
then in the view...

```php
//body can be accessed 
<?php echo $body; ?>

//heading can be accessed as an array
<?php 
foreach ($heading as $head) {
    echo $head['title'];
    ...etc.
}

?>
```

## Models

In Sippy models are classes that deal with data (usually from a database), a sample database is provided, load the testdb.sql file into sequel pro or your SQL gui of choice. For example:

```php
<?php

class Example_model extends Sippy_model {
  
    public function getSomething($id)
    {
        $id = $this->escape($id);
        $result = $this->query("SELECT * FROM something WHERE id='{$id}' ");
        return $result;
    }

}

?>
```
...then in a controller you would do:

```php
function index()
{
    $example = $this->Model('Example_model');
    $data['something'] = $example->getSomething($id);
    
    $template = $this->View('main_view',$data);
    $template->render();
}
```
Now the results of your database query would be available in your view in $someval. Connecting to the MySQL Database can be done in your `config/config.php` file (remember to rename the `sample.config.php` file):
```php
$config['db_host'] = ''; // Database host (e.g. localhost)
$config['db_name'] = ''; // Database name
$config['db_username'] = ''; // Database username
$config['db_password'] = ''; // Database password
```
There are several helper functions that can also be used in models:

* `query($query)` - Returns an array of results from a query
* `getrow($query)` - Returns one row from the query
* `getrowobj($query)` - Returns a row as an object
* `execute($query)` - Returns the direct result from a query
* `escape($string)` - Escape strings before using them in queries
* `insert($table, $dataArray)` - Insert into a table with an array

# HTML and Escaping Output to the Browser and Element Builder

There is a baked in HTML helper that you can use in controllers and views via $this->html->esc() and more, in your URL when you run sippy go to URL main/test to see available functionality.

# Helpers & Plug-ins

There are two types of additional resources you can use in Sippy.

Helpers are classes which you can use that don't fall under the category of "controllers". These will usually be classes that provide extra functionality that you can use in your controllers. Sippy comes with helper classes (Session_helper and Url_helper) which are examples of how to use helpers.

Plugins are literally any PHP files and can provide any functionality you want. By loading a plugin you are simply including the PHP file from the "plugins" folder. This can be useful if you want to use third party libraries in your Sippy application.

# Session Helper
How to use, in controller...

    protected $sess;
    
    public function __construct() {
        parent::__construct();
        $this->Helper('Session_helper');
        $this->sess = new Session_helper;
    }
    
    public function sample() {
        $this->sess->set('email', 'myemail@email.com'); //set session variable
        $this->sess->get('email'); //get session variable
        $this->sess->destroy(); //destroy session, good for logout method
    }
    
# Mailer Plugin
How to use, in controller...

    public function __construct() {
        parent::__construct();
        $this->Plugin('Mailer');
    }
    
    public function sample() {
        $send = Mailer::make()
        ->setTo('toemail@gmail.com', 'ToPerson')
        ->setFrom('fromsippy@noreply.com', 'Sippy')
        ->setSubject('Hello World Test')
        ->setMessage('Test message form sippy')
        ->setHtml()
        ->setWrap(100)
        ->send();
    }


# Extending Sippy

To extend Sippy, there’s an option to add “hooks”.  Hooks allow you to extend the whole framework and/or add functionality.  To activate ‘hooks’ go into your config.php file and enable it.  Then in the config/hooks.php file add your hook function.  Hooks are global and there are three of them; `before_system` (loads before system calls), `before_controller` (loads before controllers), and `after_controller` (loads after controllers).  Here’s an example...
```php
// in hooks.php file
$hook['before_system'] = function() {
  echo "hello world";
};
```
This hook will globally load this function that says “hello world”.  Since you can only load a hook one time, if you have more than one function to call, you can stack them like so...
```php
//... your functions ... function func1() {...do stuff...}
$hook['before_system'] = function() {
  func1();
  func2();
  func3();
};
```
# Quick n Dirty Command line

$ php bin/sippy.php [options]

try

$ php bin/sippy.php -help

* add tasks n things to bin/sippy.php file
