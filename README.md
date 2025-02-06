## What is this?

PeopleOS is the spiritual successor of Monica, the personal CRM.

How is PeopleOS different?

- it's designed to be much simpler, more focused.
- data is fully encrypted at rest. This comes with severe drawbacks, but at least data is secure.
- it's not using Javascript frameworks for the frontend. We use JS to enhance the user experience, but the core is still server-side rendered.
- the code is simple, and predictable.
- it's designed to be self-hosted.
- it's designed to be API-driven.

## Installation

peopleos is a regular Laravel application; it's build on top of Laravel and uses regular Blade / Tailwind CSS for the frontend, sprinkled with Alpine.js and Alpine AJAX for some interactivity. We stick to the Laravel conventions as much as possible.

In terms of local development, you can use the following requirements:

- PHP 8.4 - with SQLite, GD, and other common extensions.
- Node.js 16 or more recent.

If you have these requirements, you can start by cloning the repository and installing the dependencies:

```bash
git clone https://github.com/djaiss/peopleos.git

cd peopleos

git checkout -b feat/your-feature # or fix/your-fix
```

> **Don't push directly to the `main` branch**. Instead, create a new branch and push it to your branch.

Next, install the dependencies using [Composer](https://getcomposer.org) and [NPM](https://www.npmjs.com):

```bash
composer install

npm install
```

After that, set up your `.env` file:

```bash
cp .env.example .env

php artisan key:generate
```

Prepare your database and run the migrations:

```bash
touch database/database.sqlite

php artisan migrate
```

Link the storage to the public folder:

```bash
php artisan storage:link
```

In a **separate terminal**, build the assets in watch mode:

```bash
npm run dev
```

Also in a **separate terminal**, run the queue worker:

```bash
php artisan queue:work
```

Finally, start the development server:

```bash
php artisan serve
```

> Note: By default, emails are sent to the `log` driver. You can change this in the `.env` file to something like `mailtrap`.

# Specific instructions

## API Doc

We use Scribe to generate the API documentation. To generate the documentation, run the following command:

```bash
php artisan scribe:generate
```

Once the documentation is generated, the API is available at `/docs`.

If you need to test the API, we provide a [Bruno](https://www.usebruno.com/) collection in the `docs/bruno` directory. You can import this collection into Bruno.
