Bracket
=======
Database using .json files for prototyping

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
    bracketdb/data/.htaccess
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
DB::table('users'); 
```

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

### Methods

| Method  | Info |
| ------------- | ------------- |
| all()  | Returns whole table. |
| get() | Gets the object. |
| count() | Counts how many rows is in the object. |
| first() | Gets the first object. |
| max() | Returns highest column value. |
| min() | Returns lowest column value. |
| avg() | Returns average column value. |
| sum() | Returns sum of all column. |
| find() | Finds row by ID or specified column. |
| lists() | Returns all values of specific column. |
| where() | Condition (column, operator, value). |
| andWhere() | Same as where(), but used as chain method. |
| insert() | Inserts data (array) to table. |
| insertAutoId() | Inserts data (array) with auto-assigned ID to table. |
| orderBy() |  Orders data ascending or descending. |
| reorder() | Reorders records by column value and saves it. |
| structure() | Returns structure of table. |
| limit() | Sets limit to read methods. |
| save() | Saves table. |
| delete() | Deletes row. |

##### Select all
```php
DB::table('users')->all();
```
Example (display all users with their ID and Name):
```php
foreach(DB::table('users')->all() as $user) {
	echo "<br>ID:".$user->id;
	echo "<br>Name:".$user->name;
	echo "<br>";
}
```

##### Select & Where & andWhere
```php
DB::table('users')->where($column, $operator, $value);
```
Example:
```php
echo DB::table('users')->where('id', '=',  '1')->first()->id;
```
```first()``` is required to get first and only row in this case.

| Operator  | Meaning |
| ------------- | ------------- |
| =  | equal(s)  |
| ==  | equal(s) |
| != | not equal(s) |
| <> | different than |
| < | less than |
| > | great than |
| <= | less or equal than |
| >= | great or equal than |

```addWhere()``` can be added to the end for extra condition. 

##### Order By
```php
DB::table('users')->orderBy($column, $type);
```
Example:
```php
echo DB::table('users')->orderBy('name', 'asc')->get()[0]->name;
```
```php
$arr = DB::table('users')->orderBy('name', 'asc')->get();

foreach($arr as $r) {
	echo $r->name;
}
```
```asc``` for ascending order, ```desc' for descending.

##### Reorder
Similiar to orderBy. It reorders all data  and saves it.
```php
DB::table('users')->reorder($column);
```
Example:
```php
DB::table('users')->reorder('name');
```

##### Edit
```php
$table = DB::table('users');
$table->where('id', '=',  '1')->first()->name="New name";
$table->save();
```

Documentation not fully done yet.
-------
