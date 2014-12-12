Bracket
=======
JSON database using ORM for PHP prototyping

Requirements
-------
- PHP 5.4+

Best used for 
-------
 - Prototypes/small projects
 - When you want to store some data in JSON file instead of MySQL database.

Setup
-------
Make sure you have following structure in your project:

    bracketdb/
    bracketdb/data
    bracketdb/trash
    bracketdb/Bracket.php

Add to working PHP file(s).
```php
use Bracket\BracketDB as DB;
include('bracketdb/Bracket.php');
```

### Database actions
##### Create table
```php
DB::create('users'); 
```
This is going to create ```users.json``` in ```bracketdb/data```.

##### Connect
```php
$table = DB::table('users'); 
```
From here, you can use ```$table``` as an object and access its methods.
 
##### Trash table
```php
DB::trash('users'); 
```
Moves ```users.json``` to ```bracketdb/trash```.
 
##### Restore table
```php
DB::restore('users'); 
```
If ```bracketsdb/trash/users.json``` exists, it will be restored.

##### Delete table
```php
DB::delete('users'); 
```
This will permanently delete ```users.json``` from file system.

 
