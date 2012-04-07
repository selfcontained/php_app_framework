## Generic PHP Application Framework

[visit project page](http://bmharris.github.com/php_app_framework/)

This is a pretty lightweight and generic framework for building out a simple PHP application. It's built to be completely extendable so you can add your own custom behavior, but also provide default solutions to common tasks.  It provides the following tools:

+	class autoloading
+
+	routing
+	modular request handler interface with the following handlers included
	+	controller handlers
	+	view handlers
	+	less css handler

#Front Controller

The Application Front Controller is an extremely simple class and concept.  It is available to register Request Handlers on, and then to be dispatched, which in turn starts the execution stack of those request handlers.  It also provides a mechanism to make data from Request Handlers available to other Handlers.

#Request Handlers

Request Handlers are what make your application run.  They can be added to the application by registering them with the Application Front Controller.

```
Application\FrontController::initialize(__DIR__.'/../')
	->handler(new Routing\Manager(__DIR__.'/../config/routes.php'))
	->handler(new Application\Request\Handler\ResponseCache())

	->dispatch();
```

You can create Request Handlers for whatever you want, and they provide a mechanism for you to alter your Application's behavior through injecting your logic during key events, which are triggered through the following functions:

+	preExecute
+	execute
+	postExecute

You're Request Handler should extend _Application\Request\Handler\Base_ and can override any of the three functions that are available.
