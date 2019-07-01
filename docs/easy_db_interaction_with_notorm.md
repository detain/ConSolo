# Database Interaction Made Easy with NotORM

Object Relational Mappers (ORMs) are cool. They help you to rapidly create your application without worrying about writing raw SQL queries. The idea is to simplify database interaction and avoid possible errors in writing complex queries. In fact, modern ORMs can generate Models/Entities from the database, and vise versa.

But the reality of working with any ORM is that using it is only simple if you already have experience using it. To make the most out of it, you should have a deep understanding of the concepts. And there’s a steep learning curve associated with any ORM.

If all you are developing is a simple application with a few tables, using a full-fledged ORM is probably overkill. In this case, you may want to consider using NotORM. NotORM is easy to learn and simple to use because it provides an intuitive API to interact with the database. In this article I’ll be teaching you how to use NotORM.

Before we get started though, here’s the database layout which I’ll be using throughout the article.

```
Table: author
+----+------------------------+
| id | name                   |
+----+------------------------+
|  1 | Khalil Gibran          |
|  2 | Sir Arthur Conan Doyle |
|  3 | Paulo Coelho           |
+----+------------------------+
Table: book
+----+-----------------+-----------+
| id | title           | author_id |
+----+-----------------+-----------+
|  1 | The Prophet     |         1 |
|  3 | Sherlock Holmes |         2 |
|  4 | The Alchemist   |         3 |
+----+-----------------+-----------+
Table: category
+----+------------+
| id | category   |
+----+------------+
|  1 | poem       |
|  2 | article    |
|  3 | tutorials  |
|  4 | philosophy |
|  5 | essays     |
|  6 | story      |
+----+------------+
Table: book_category
+----+---------+-------------+
| id | book_id | category_id |
+----+---------+-------------+
|  1 |       1 |           4 |
|  3 |       3 |           6 |
|  4 |       4 |           4 |
+----+---------+-------------+
```

## Connecting to the Database

The first step to using NotORM is to create an instance of the `NotORM` object which uses an active PDO connection to interface with the database.

```
<?php
$dsn = "mysql:dbname=library;host=127.0.0.1";
$pdo = new PDO($dsn, "dbuser", "dbpassword");
$library = new NotORM($pdo);
```

A Data Source Name (DSN) is a common way of describing a database connection. It contains the name of the database driver use, database name, and host address. The PDO constructor accepts a DSN and database username and password to connect. Once connected, the PDO object is passed to NotORM. We will use this NotORM instance throughout this article.

## Basic Retrieval

Now that we are connected through NotORM, let’s list all of the books in the database.

```
<?php
$books = $library->book();
foreach ($books as $book) {	
    echo $book["id"] . " " . $book["title"] . "<br>";
}
```

The result is:

```
1 The Prophet3 Sherlock Holmes4 The Alchemist
```

It’s as simple as that! `$library` is the NotORM object and `book` is the table name where our book information is stored. The `book()` method returns an multi-dimensional array with the table’s primary key column as the first-level index. Within the `foreach`, `$book` is a representation of a single book record, an array with keys named after the table’s column names. `$book["title"]` returns the value from the title column for that record.

In most cases you won’t be interested in retrieving all columns from the table. You can specify just the columns you are interested in through the `select()` method. For instance, if you only want the title, you could re-write the example as:

```
    <?php
    $books = $library->book()->select("title");
    foreach ($books as $book) {	
        echo $book["title"] . "<br>";
    }
```

Retrieving specific columns is especially desirable on tables that have a large number of columns, this way you don’t have to waste time and memory retrieving and storing values you won’t use.

To fetch a single record from the table using its primary key, we reference the primary key in a query’s `WHERE` clause when writing SQL. In NotORM, There are many ways we can accomplish the task; the easiest way is to use the primary key as an index to the table property.

```
    <?php
    $book = $library->book[1];
    echo $book["title"];
```

This will simply retrieve the get the book details from the record with ID 1.

## Filtering on Column Values

NotORM allows for filtering results on conditions that would be specified in the query’s `WHERE` clause using the `where()` method. To illustrate, let’s search the table for books with a title containing “Alchemist”.

```
    <?php
    $books = $library->book->where("title LIKE ?", "%Alchemist%");
    foreach ($books as $book) {	
        echo $book["id"] . " " . $book["title"] . "<br>";
    }
```

The result is:

```
<pre>4 The Alchemist</pre>
```

If you are not familiar with prepared statements, you may be wondering what that question mark means. This is a way of binding paremeters to the queries executed by PDO so that you can execute the same query many times just by changing the values. A question mark, or a variable like `:title`, acts like a value place holder. You can read more about PDO’s prepared statements in the PHP manual.

NotORM also allows you to chain `where()` methods to apply more than one condition.

```
    <?php$books = $library->book->where("title LIKE ?", "%The%")				   ->where("id < ?", 5);foreach ($books as $book) {	echo $book["id"] . " " . $book["title"] . "<br>";}
```

<pre>1 The Prophet4 The Alchemist</pre>

The statement issued by NotORM for the above example is equivalent to the following SQL query:

```
    SELECT * FROM book WHERE title LIKE "%The%" AND id < 5
```

## Sorting Results

Chances are rare that you’ll have straight forward queries with a single table throughout your whole application. In real life applications, you’ll need to join many tables, order records based on the values in different columns, limit the number of records retrieved, and so on.

You can order results based on one or more columns, ascending or descending order. The example given below will return books in descending order of their IDs.

```
    <?php$books = $library->book->order("id desc");foreach ($books as $id => $book) {	echo $id . " " . $book["title"] . "<br>";}
```

<pre>4 The Alchemist3 Sherlock Holmes1 The Prophet</pre>

If you want to order the results based on more than one column, you can specify them separated by commas.

```
    <?php$books = $library->book->order("id desc, title asc");foreach ($books as $id => $book) {	echo $id . " " . $book["title"] . "<br>";}
```

The resulting records will be returned in descending order of their ID and if there’s more than one records with the same ID (of course there won’t be) it will be in ascending order of the title.

NotORM supports limiting the results, too. Let’s limit the result set to two records, starting from offset 0:

```
    <?php$books = $library->book->limit(2, 0);foreach ($books as $id => $book) {	echo $id . " " . $book["title"] . "<br>";}
```

<pre>1 The Prophet3 Sherlock Holmes</pre>

## Joining Tables

So far we were discussing about listing books or getting NotORM work with only one table. Now we want to move further, like finding out who authored the book and so on.

Let’s try to list the books along with their authors. In our library database, the book table has a foreign key `author_id` which references the `author` table (each book can have only one author in this set-up).

```
    <table> <tr><th>Book</th><th>Author</th></tr><?php$books = $library->book();foreach ($books as $book) {    echo "<tr>";    echo "<td>" . $book["title"] . "</td>";    echo "<td>" . $book->author["name"] . "</td>";    echo "</tr>";}?></table>
```

The output of above code is:

```
<pre>**Book**             **Author**The Prophet      Khalil GibranSherlock Holmes  Sir Arthur Conan DoyleThe Alchemist    Paulo Coelho</pre>
```

When you call `$book->author["name"]`, NotORM automagically links the `book` table with the `author` table using the `author_id` column and retrieves the author details for the book record. This is a case of a one-to-one relationship (a record in parent table will be linked to only one record in child table) relations.

In the case of one-to-many relations, the secondary table will have more than one record corresponding to a single row in the primary table. For example, let’s assume we can write reviews for book, so for each book there will be zero or more reviews which which are stored in another table. For each each book then you will need another loop to display its reviews, if any.

For many-to-many relationship, there will be a third table linking the primary and secondary tables. We have a `category` table to keep book categories in, and a book can have zero or more categories associated with it. The link is maintained using the `book_category` table.

```
    <table> <tr><th>Book</th><th>Author</th><th>Categories</th></tr><?phpforeach ($books as $book) {    echo "<tr>";    echo "<td>" . $book["title"] . "</td>";    echo "<td>" . $book["author"] . "</td>";    // book_category table joins book and category    $categories = array();    foreach ($book->book_category() as $book_category) {        $categories[] = $book_category->category["category"];    }    echo "<td>" . join(", ", $categories) . "</td>";    echo "</tr>";}?> </tr></table>
```

<pre>**Book**             **Author**                 **Categories**The Prophet      Khalil Gibran           philosophySherlock Holmes  Sir Arthur Conan Doyle  storyThe Alchemist    Paulo Coelho            philosophy, story</pre>

When you call the `book_category()` method, it will get the records from the `book_category` table, which in turn will connect to the `category` table using `$book_category->category["category"]`.

There are some default conventions for table and column names that, if you follow, can make working with table relationships easier in NotORM.

*   The table name should be singular, i.e. use _book_ for the name of a table to store book details.
*   Use _id_ as the primary key for your tables. It’s not necessary to have primary keys for all tables, but it’s a good idea.
*   Foreign keys in a table should be named as _table_id_.

Like I said, these are only default conventions. You can follow different convention if you want, but then you need to inform NotORM of the conventions it should follow. The library has a class, `NotORM_Structure_Convention` for defining the naming convention. Here’s a simple example of how to use, which I copied from the NotORM website.

```
    <?php$structure = new NotORM_Structure_Convention(    $primary = "id_%s", // id_$table    $foreign = "id_%s", // id_$table    $table = "%ss", // {$table}s    $prefix = "wp_" // wp_$table);$db = new NotORM($pdo, $structure);
```

The example changes all of the table names to plural and prefixed with “wp_” . The primary key and foreign keys have been changed to _id_table_.

## Data Persistence

Up until now we’ve discussed retrieving data that’s already in the database. Next we need to look at storing and updating the data as well.

Inserts and updates are pretty simple and straight forward. You only need to create an associative array with the column names as keys and pass it as an argument to the table’s `insert()` or `update()` method.

```
<?php$book = $library->book();$data = array(    "title" => "Beginning PHP 5.3",    "author_id" => 88);$result = $book->insert($data);
```

`insert()` will return the record if insertion was successful or false if it failed. From there, you can get the ID of the inserted record using `$result["id"]`.

To update a book, fetch the book record from the database using its primary key and then pass the values that should be updated as an array to `update()`.

```
<?php$book = $library->book[1];if ($book) {    $data = array(        "title" => "Pro PHP Patterns, Frameworks, Testing and More"    );    $result = $book->update($data);}
```

`update()` will return true on success or false if the update failed.

Similarly, you can delete a book by calling `delete()` on a book object.

```
    <?php$book = $library->book[10];if ($book && $book->delete()) {    echo "Book deleted successfully.";}
```

It’s important to remember when you update or delete a row that you first make sure it exists in the database, otherwise your script will throw a fatal error.

## Summary

Through this article you’ve become familiarized with a simple library for interacting with your database. The reality is that as your application grows, the code using NotORM will become less manageable and so you’ll need to decide whether NotORM is suitable based on the expected size of your application and other factors. But when using NotORM, you don’t need to worry about writing raw SQL queries or creating entity classes with complex relationships. Rather, you can use the familiar object oriented notation to deal with tables and columns straight away.
