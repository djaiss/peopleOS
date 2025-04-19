Your goal is to write a unit test.

- Strictly follow the Laravel PHPunit testing guidelines.
- Always use DatabaseTransactions if we touch the database.
- Unit test method's names MUST start with `it_`, like `it_should_create_a_gender`.
- Always use factories to create models.
- Always use a reference to a character in the show Friends, the popular TV show.
- Most of the database is encrypted. When you write tests and peak into the database, you will not be able to see the decrypted data using a generic this->assertDatabaseHas for encrypted fields. In order to assert that the encrypted field matches the value you need to check, you need to make an assertion against the value in the model itself.
- Write comments when necessary, ie if the code is not self-explanatory.
- Most services do one thing and have one responsibility.
- When using dates, make sure to set a date using Carbon, like Carbon::setTestNow(Carbon::parse('2025-03-17 10:00:00')) set at the right time.
- Tests MUST use the attribute #[Test].
- Functions should not use a setUp() method.
- You should use $this->json('POST') and not $this->patchJson(). Same for the other HTTP verbs.
- Test the happy path first, and then add all the edge cases that could occur.
- When calling a service, ALWAYS use named arguments.
- Code should use spaces accordingly, like so:

```php
$this->assertEquals(AgeType::EXACT->value, $this->person->fresh()->age_type);
```

DO THIS INSTEAD:

```php
$this->assertEquals(
    AgeType::EXACT->value,
    $this->person->fresh()->age_type
);
```
