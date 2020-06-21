<?php

class Database {

private $pdo /*PDO class*/, $query /*PDOStatement*/, $error = false, $results /*array*/, $count /*integer*/;

// L#3 - General singleton class - https://phpenthusiast.com/blog/the-singleton-design-pattern-in-php
// https://stackoverflow.com/questions/12553142/when-we-should-make-the-constructor-private-why-php/12553289
// Hold the class instance (by default $instance is null)
private static $instance = null;

// The constructor is private to prevent initiation with outer code.
private function __construct()
{
    // The expensive process (e.g.,db connection) goes here.
    try {
        $this->pdo = new PDO(
            "mysql:host=" . Config::get('mysql.host') . "; dbname=" . Config::get('mysql.database'),
            Config::get('mysql.username'),
            Config::get('mysql.password')
        );
        // echo 'ok';
    } catch (PDOException $exception) {
        die($exception->getMessage());
    }
}

// The object is created from within the class itself only if the class has no instance.
public static function getInstance()
{
    // if $instance do not exist, create it
    if(!isset(self::$instance)) {
        self::$instance = new Database;
    }
    return self::$instance;
}


// L#4
private function query($sql, $params = [])
{
    // Set $error property to FALSE before running the query (L#4 8:00)
    $this->error = false;
    
    /* Call the `prepare method` of class PDO object (pdo # $pdo !!!), passing it our SQL string
    as an argument. This sends the query to the MySQL server, asking it to prepare to run the query.
    MySQL can’t run it yet—there’s no value for the `$parameters`.
    PDO::prepare — Prepares a statement for execution and returns a statement object.
    calling `PDO::prepare()` and `PDOStatement::execute()` helps to prevent
    SQL injection attacks by eliminating the need to manually quote and escape the parameters */
    $this->query = $this->pdo->prepare($sql);
    /* $sql - must be a valid SQL statement template for the target database server
    
    If the database server successfully prepares the statement, 
    `PDO::prepare()` returns a `PDOStatement object`.
    If the database server cannot successfully prepare the statement,
    `PDO::prepare()` returns FALSE or emits `PDOException` (depending on error handling). */

    // L#5 
    if(count($params)) { // if `$params` array not empty bind a value to a parameter
        // before running the loop - set parameter identifier equal to 1
        $i = 1;
        foreach($params as $param) {
            /* PDOStatement::bindValue — Binds a value to a parameter
            Binds a value to a question mark placeholder in the SQL statement 
            that was used to prepare the statement 
            1) `$i` - parameter identifier - For a prepared statement using question mark placeholders, 
            this will be the 1-indexed position of the parameter.
            2) The value to bind to the parameter */
            $this->query->bindValue($i, $param);
            $i++; // increase parameter identifier by 1
        }
    }

    /* PDOStatement::execute — Executes a prepared statement.
    Returns TRUE on success or FALSE on failure.*/
    if(!$this->query->execute()) {
        // if execution failed - set Database object's `$error property` to TRUE
        $this->error = true;
    } else {
    
    /* Set the Database object's prperty `results`.
    All PDO "fetch" methods, requests an optional parameter called `$fetch_style` 
    that means the data structure which your entity will be returned, 
    when you use PDO::FETCH_OBJ it means that your entity will be an stdClass instance*/
    $this->results = $this->query->fetchAll(PDO::FETCH_OBJ);
    
    /* Set the Database object's prperty `count`.
    PDOStatement::rowCount — Returns the number of rows affected by the last SQL statement
    Returns the number of rows affected by the last DELETE, INSERT, or UPDATE statement
    executed by the corresponding PDOStatement object.
    SELECT statement - some databases may return the number of rows returned by that statement.
    !!! However, this behaviour is not guaranteed for all databases and should NOT be relied on 
    for portable applications */
    $this->count = $this->query->rowCount();
    }
    return $this;
}


// Returns the `$error property` of `Database object`
// we can't access PRIVATE property `$error` from external page to access it use PUBLIC `error method`
public function error()
{
    return $this->error;
}


// Returns ARRAY - the `$results property` of `Database object`
// we can't access PRIVATE property `$results` from external page to access it use PUBLIC `results method`
public function results()
{
    return $this->results;
}


// Returns INTEGER - the `$count property` of `Database object`, which represents the number of rows 
// affected by the last query statement executed.
// we can't access PRIVATE property `$count` from external page to access it use PUBLIC `count method`
public function count()
{
    return $this->count;
}



// Select all records from a db's table (20.06.2020)
// Returns Database Object containing all of the result set rows
public function findAll(string $table)
{
    $sql = "SELECT * FROM `{$table}`";
    
    // call the `query method` on `Database object`
    $this->query($sql);

    return $this;
}


// searches the db for records that have a value set for a specified column.
// `$where array` contains 3 elements: 1) criteria's field name 2) operator 3) criteria's value
public function findByCriteria($table, $where = [])
{
// call the `action() method` on `Database object`
return $this->action('SELECT *', $table, $where);
}


public function delete($table, $where = [])
// `$where array` contains 3 elements: 1) criteria's field name 2) operator 3) criteria's value
{
    return $this->action('DELETE', $table, $where);
}


// Returns Object of Database class
private function action($action, $table, $where = [])
// `$where array` contains 3 elements: 1) criteria's field name 2) operator 3) criteria's value
{
    /* check whether the` $where array` contains 3 elements if it does NOT return FALSE
    if any element in the` $where array` is missing there no sense to execute a query 
    PHP count() Functionc - Return the number of elements in an array
    Parameter Values:
    array	Required. Specifies the array
    mode	Optional. Specifies the mode. Possible values:
            0 - Default. Does not count all elements of multidimensional arrays
            1 - Counts the array recursively (counts all the elements of multidimensional arrays) */
    if(count($where) === 3) {

        $operators = ['=', '>', '<', '>=', '<=']; // create the Indexed array of operators

        // assign the values from the `$where array` to variables
        $field = $where[0];     // criteria's field name
        $operator = $where[1];  // operator
        $value = $where[2];     // criteria's value

        /* Check whether the value of the `$operator variable` is in the `$operators array`.
        If the `$operators array` DOES contain the operator from the `$where array
        then execute the query. If it does NOT return FALSE
        The `in_array() function` searches an array for a specific value.
        Parameter Values:
        1) search	Required. Specifies the what to search for
        2) array	Required. Specifies the array to search
        3) type	    Optional. If this parameter is set to TRUE, the `in_array() function`
                    searches for the search-string and specific type in the array.
        Return Value:	Returns TRUE if the value is found in the array, or FALSE otherwise */
        if(in_array($operator, $operators)) {
            // set `$sql` string
            $sql = "{$action} FROM {$table} WHERE {$field} {$operator} ?";
            
            // call the `query method` on `Database object`
            $this->query($sql, [$value]);
            
            return $this;
        }
    }
}


/* L#7 - Returns TRUE if insert is successful or FALSE on failure.
Parameter Values:
1) string	Required. Specifies the name of a table in which a data will be added
2) array	Required. Specifies the array of table's fields */
public function insert($table, $fields = [])
{
    $values = '';
    
    /* loops over the array given by `$fields`. On each iteration, the VALUE of the current element is 
    assigned to `$field` (NEW variable` that will be used to store each item's value of the array) and
    the internal array pointer is advanced by one (so on the next iteration, you'll be looking at the next element) */
    foreach($fields as $field) {
        /* On each iteration add `?,` to the string, so the string will contain as many `?,` symbols 
        as there are elements in the array*/
        $values .= "?,";
    }
    $val = rtrim($values, ',');
    // var_dump($val);die;

    /* `array_keys()` in-build function - returns an array containing the keys (numeric and string) of an array.
    Parameters:
    1) array -  Required. An array containing keys to return
    2) value -  Optional. You can specify a `value`, then only the keys with this value are returned
    3) strict - Optional. Used with the `value parameter`. Possible values:
                true - Returns the keys with the specified value, depending on type: the number 5 is not the same as the string "5".
                false - Default value. Not depending on type, the number 5 is the same as the string "5" */
    $sql1 = array_keys($fields);
    // var_dump($sql1);die;

    /* `implode()` in-build function - Join array elements with a glue string.
    Parameters:
    1) glue -   Optional. Specifies what to put between the array elements. Default is "" (an empty string);
    2) pieces - Required. The array to join to a string
    Returns a string containing a string representation of all the array elements 
    in the same order, with the glue string between each element*/
    $sql2 = implode('`, `', array_keys($fields));
    // var_dump($sql2);die;
    
    $sql = "INSERT INTO {$table} (`{$sql2}`) VALUES ({$val})";
    // var_dump($sql);die;

    // run the `query method` and after that the `error method` to check whether an error has accured
    // if an error has accured the `$error property` of Database object will be `TRUE`
    if(!$this->query($sql, $fields)->error()) {
        // if the `$error property` of Database object is `FALSE`
        return true;
    }
    // if the `$error property` of Database object is `TRUE`
    return false;
}


/* L#8 - Returns TRUE if update is successful or FALSE on failure.
Parameter Values:
1) string - Required. Specifies the name of a table in which a data will be updated
2) string - Required. Specifies the value of ID of the record
3) array -  Required. Specifies the array of table's fields */
public function update($table, $id, $fields = [])
{
    $set = '';

    /* foreach (array_expression as $key => $value)
    Loops over the array given by array_expression. On each iteration:
    1) the value of the current element is assigned to `$value variable`
    ($value - name of a NEW variable, that will be used to store the VALUE of each element of the array)
    2) additionally assign the current element's key to the `$key variable` 
    ($key - name of a NEW variable, that will be used to store the KEY of each element of the array)
    and the internal array pointer is advanced by one (so on the next iteration, you'll be looking at the next element).
    */
    foreach($fields as $key => $value) {
        $set .= "`{$key}` = ?,"; // username = ?, password = ?,
    }

    $set = rtrim($set, ','); // username = ?, password = ?

    $sql = "UPDATE `{$table}` SET {$set} WHERE `id` = {$id}";
    //var_dump($sql);die;

    if(!$this->query($sql, $fields)->error()){
        return true;
    }

    return false;
}


// returns stdClass Object - the first record from a recordset
public function first()
{
    return $this->results()[0];
}

}
