
# Emputantular Framework

PHP framework with SinglePageApplication using vanilla.JS and native PHP.


## Features

 - SPA (Single Page Application) using vanilla.js for best performance!
 - Query Builders
 - Migrations and Seeders
 - Modular App
 - Database Supports: Postgresql, MySql


## Running Tests

After setup your .env file, run the following command

```bash
  composer install
  php -S 0.0.0.0:3000
```
## Tech Stack

**Client:** Vanilla.JS

**Server:** PHP


## Usage/Examples

#### Routes

Call routes library first
```php
  use Empu\Routes;
```

| Function  | Description                                   |
| :-------- | :-------------------------------------------- |
| `group('/your_group')` | You can grouping routes inside this function |
| `get('/heroes')` | Route for method GET |
| `get('/heroes/{$param}')` | GET method with parameter |
| `post('/heroes')` | Route for method POST |
| `put('/heroes')` | Route for method PUT |
| `delete('/heroes/{$id}')` | Route for method DELETE |

#### Routes Example

```php
  $route->group('/avengers', function($route) {
    $route->get('/heroes', HeroesCtrl::class . 'index');
    $route->get('/heroes/{$param}', HeroesCtrl::class . 'detail');
    $route->post('/heroes', HeroesCtrl::class . 'insert');
    $route->put('/heroes', HeroesCtrl::class . 'update');
    $route->delete('/heroes/{$param}', HeroesCtrl::class . 'delete');
  });
```

#### Sessions

First of all you have to setup CONF_SESS_DRIVER in your .env file, you can fill it with cache or database, if you choose database, Framework will create database called "empu_sessions" automatically

Then call session library
```php
  use Empu\Session;
```

| Function | Parameter     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `get`      | `name` | **Required**. Get data by name from your session |
| `store`      | []`data` | **Required**. Store your data to session |
| `unset`      | `name` | **Required**. Remove session by name |
| `destroy`      |  | It will remove all session in your application |

#### Session Example
```php
  Session::get('logged_heroes');
  Session::store(['logged_heroes' => 'Spiderman']);
  Session::unset('logged_heroes');
  Session::destroy();
```


#### Query Builder

Setup your .env file for connecting to database, in DB_DRIVER you can fill it with "postgre" or "mysql"

| Function | Type     | Description                       |
| :-------- | :------- | :-------------------------------- |
| `table`      | `string` | **Required**. Your tablename |
| `select`      | `string` | **Required**. Field you want to select from table |
| `where`      | `string`,`string` | Conditions when you try to select data  |
| `orderBy`      | `string`,`string` | Ordering your data by field choosen |
| `limit`      | `int` | Limit your data |
| `offset`      | `int` | Offset your data |
| `insert`      | `array` | Insert your data to database |
| `update`      | `array` | **Required** where(), Update your data to database |
| `delete`      |  | **Required** where(), Delete your data by conditions |
| `raw`      | `string` | Raw query if you need complex query |
| `get`      |  | Execute builder to get all data |
| `first`      |  | Execute builder to get first data |

#### Query Builder Example

You can directly access to db with $this->DB
```php
  // GET ALL DATA
  $this->DB->table('heroes')
    ->select('id','fullname','strength')
    ->orderBy('fullname', 'DESC')
    ->limit(10)
    ->limit(0)
    ->get();
```
```php
  // GET ONE DATA
  $this->DB->table('heroes')->select('id','fullname','strength')->first();
```
```php
  // WITH CONDITIONS
  $this->DB->table('heroes')
    ->select('id','fullname','strength')
    ->where('strength', '>', 100)
    ->where('deleted', false) // default operator is =
    ->get();
```
```php
  // INSERT DATA
  $this->DB->table('heroes')->insert([
    'fullname' => 'Spiderman',
    'strength' => 10000
  ]);
```
```php
  // UPDATE DATA
  $this->DB->table('heroes')
    ->where('id', '1')
    ->update([
      'strength' => 20000
    ]);
```
```php
  // DELETE DATA
  $this->DB->table('heroes')
    ->where('id', '1')
    ->delete();
```

#### Migrations

Create migration file in databases/migrations, example below:
```php
  namespace Migrations;
  use Empu\Model;

  class Heroes extends Model
  {
    public function up(): void
    {
      $this->schema('heroes', function($table) {
        $table->uuid('id')
          ->primary_key();

        $table->varchar('fullname')
          ->length(100)
          ->comment('default fullname')
          ->nullable(true);

        $table->numeric('strength')
          ->length(10)
          ->comment('hero strength!')
          ->nullable(true);
      });
    }

    public function down(): void
    {
      $this->schema_drop('heroes');
    }
}
```

Then run with following command:
```bash
    php commands/migrations.php
```
It will run all your migration files, if you want to be more specific you can use
```bash
    php commands/migrations.php --filename=Heroes
```
Which means Heroes is you filename /databases/migrations/heroes.php, use --type=up for create table and --type=down for dropping table
```bash
    php commands/migrations.php --filename=Heroes --type=up
    -- OR --
    php commands/migrations.php --filename=Heroes --type=down

    -- DO IT FOR ALL FILES --
    php commands/migrations.php --type=up
    php commands/migrations.php --type=down
```

#### Seeders
Create migration file in databases/seeders, example below:
```php
    namespace Seeders;
    use Empu\Model;

    class Heroes extends Model 
    {
        public function up(): void
        {
            $data = [];
            $data[] = [
                'id' => '16cd9b1e-d947-46b3-ae3a-2a1207a504b1',
                'fullname' => 'Spiderman',
                'strength' => 1000,
                'secret_power' => 'He can walk on the wall'
            ];
            $data[] = [
                'id' => '3b9f2265-4cbd-45ec-a45a-f5479e5e1a28',
                'fullname' => 'Superman',
                'strength' => 999999999999999,
                'secret_power' => 'idk he is too strong'
            ];
            $this->seed('heroes', $data);
        }
    }
}
```
Then run with following command:
```bash
    php commands/seeders.php
```
It will run all your migration files, if you want to be more specific you can use
```bash
    php commands/seeders.php --filename=Heroes
```
Which means Heroes is you filename /databases/seeders/heroes.php

## Authors

- [@kiritoo9](https://www.github.com/kiritoo9)


## Version

2.0.1

