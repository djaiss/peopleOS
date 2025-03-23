<p align="center">
  <a href="https://github.com/djaiss/peopleos">
   <img src="docs/github/background-github.png" alt="Logo">
  </a>

  <p align="center">
    A simple, bullshit and AI free, open-source personal CRM.
  </p>

  <p align="center">
    [![codecov](https://codecov.io/gh/djaiss/peopleOS/graph/badge.svg?token=7aoDgGFZQr)](https://codecov.io/gh/djaiss/peopleOS)
    [![License: MIT](https://img.shields.io/badge/License-MIT-yellow.svg)](https://opensource.org/licenses/MIT)
  </p>
</p>

## What is this?

PeopleOS is the spiritual successor of Monica, the personal CRM.

### Features

- A powerful contact management system, with features like adding family information, work information, etc...
- A powerful, and fully customizable journal system, that lets you document your life.

Data is also fully encrypted at rest, which is nice in case someone wants to peak into the database.

### Why a Monica sequel?

How is PeopleOS different?

- it's designed to be much simpler, more focused.
- it's designed to be really fast.
- data is fully encrypted at rest. This comes with severe drawbacks, but at least data is secure.
- it's not using Javascript frameworks for the frontend. We use JS to enhance the user experience, but the core is still server-side rendered.
- the code is simple, and predictable.
- it's designed to be self-hosted.
- it's designed to be API-driven.

## Installation

peopleOS is a regular Laravel application; it's build on top of Laravel and uses regular Blade / Tailwind CSS for the frontend, sprinkled with Alpine.js and Alpine AJAX for some interactivity. We stick to the Laravel conventions as much as possible.

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

## Note for developers

This project uses the following languages:

- PHP (always the most recent version),
- CSS with Tailwind almost exclusively,
- Blade for the templating language,
- HTML, of course
- Javascript with AlpineJS,
- Ajax-like behaviour with Alpine Ajax,
- PHPUnit.

These are simple languages, chosen on purpose. They lower the barriers to entry for newcomers who want to help on the project. They are very easy to debug. They are very easy to install on any machines. They are very light in terms of resources.

We believe this project is a nice project to learn how to code and to contribute to an open source project.

### General guidelines

- This project is meant to be simple to read, simple to maintain and simple to debug.
- As a consequence, the code must be the simplest it can be. I can't put emphasis this point enough.
- Use comments to explain what you are doing.
- Write easy to understand code. Do not write lines of code that takes minutes to understand, like crazy loops and recursive stuff that make you appear smart, but waste everyone's time.
- Yes, I'm not a great developer, but I'm also the one who will maintain this project on the long run. Please help me doing so.

### Guidelines for development

- All models and controllers should be fully tested. We use PHPUnit.
- Avoid writing custom CSS as much as possible. Tailwind provides everything we need in 99.9999% of the case.
- Do not add dependencies. Dependencies are the devil. It puts the project at risk in many ways.
