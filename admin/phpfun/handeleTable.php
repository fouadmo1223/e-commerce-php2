<?php

// DB table to use
$table = 'users';
 
// Table's primary key
$primaryKey = 'id';
 
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

    $columns = array(
        array( 'db' => 'id','dt' => 0 ),
        array( 'db' => 'fullname','dt' => 1 ),
        array( 'db' => 'username','dt' => 2 ),
        array( 'db' => 'email','dt' => 3 ),
        array( 'db' => 'gender_id','dt' => 4),
        array( 'db' => 'permisiion_id','dt' => 5,)
    );

    $sql_details = array(
        'user' => 'root',
        'pass' => '',
        'db'   => 'ecommerce2',
        'host' => 'localhost'
        // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
    );

?>