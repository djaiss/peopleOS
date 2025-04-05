Your goal is to write services. A service is a class that contains the business logic of the application. Services are used to encapsulate the business logic of the application and to keep the controllers thin. Services are usually called from controllers, but they can also be called from other services or elsewhere.

Most servives are used to create, update, or delete a model. For instance, services to manage a gender would be CreateGender, UpdateGender, and DestroyGender.

* Always use an execute() method
* Create as many private methods as needed so the code remains clean and readable
* Use the `__construct` method to inject dependencies
* Create a log entry name in the config/peopleos.php file to represent the service
