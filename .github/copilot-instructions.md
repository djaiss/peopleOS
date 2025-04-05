You are an expert in the Laravel stack, using Alpine.js, Alpine Ajax and Tailwind CSS, with a strong emphasis on Laravel and PHP best practices.

# PHP specific instructions

* Use PHP 8.1+ features when appropriate (e.g., typed properties, match expressions).
* Follow PSR-12 coding standards.
* Use strict typing: declare(strict_types=1);
* Utilize Laravel's built-in features and helpers when possible.
* Follow Laravel's directory structure and naming conventions.
* Use lowercase with dashes for directories (e.g., app/Http/Controllers).
* Implement proper error handling and logging:
  * Use Laravel's exception handling and logging features.
  * Create custom exceptions when necessary.
  * Use try-catch blocks for expected exceptions.
* Implement middleware for request filtering and modification.
* Utilize Laravel's Eloquent ORM for database interactions.
* Use Laravel's query builder for complex database queries.
* Implement proper database migrations and seeders.
* Use Eloquent ORM instead of raw SQL queries when possible.
* Utilize Laravel's caching mechanisms for improved performance.
* Implement job queues for long-running tasks.
* Use Laravel's built-in testing tools (PHPUnit) for unit and feature tests.
* Use Laravel's localization features for multi-language support.
* Implement proper CSRF protection and security measures.
* Implement proper database indexing for improved query performance.
* Use Laravel's built-in pagination features.
* Implement proper error logging and monitoring.
* Make sure comments are always in English, and do not go over the ruler defined currently at 80 characters.

# Guidelines for managing routes

* Web routes are always stored in routes/web.php
* Api routes are always stored in routes/api.php
* Routes must follow the Ruby on Rails guidelines for naming routes.
* Routes can ONLY have the following actions:
    * `index` to list things
    * `new` to display the view to add something new
    * `create` to store the result of the `new` action
    * `show` to display the object
    * `edit` to edit the object
    * `update` to actually edit the object
    * `destroy` to delete the object

# Guidelines for writing api documentation

* Strictly follow the Laravel naming convention and practices.
* Documentation of the API lives in `resources/views/marketing/docs/api`.
* Documentation must be follow the pattern of the other documentation files in the folder.
* API responses must be written in a partial, stored under `resources/views/marketing/docs/api/partials` and follow the pattern of the other partials in the folder. This partial must be used in the corresponding API method documentation file, so code is reused.
* The API response must have the syntax highlighting used in other API responses.
* Padding must remain consistent with the rest of the documentation.
* At the beginning of the documentation file, add a description of the API. It should be to the point, explanatory and concise.

## Steps for writing API documentation

1. Analyse the provided API class that the documentation must cover, and check other API documentation files to see how they are written.
2. Create the documentation for the newly created API methods.
3. Create the API response partial.
