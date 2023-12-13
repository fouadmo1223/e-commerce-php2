<?php
   include "connection.php";

   $counter = 0;
// DB table to use
$table = 'messages';
    
// Table's primary key
$primaryKey = 'id';
    
// Array of database columns which should be read and sent back to DataTables.
// The `db` parameter represents the column name in the database, while the `dt`
// parameter represents the DataTables column identifier. In this case simple
// indexes

    $columns = array(
        array( 
            'db' => 'id',
            'dt' => 0,
            'formatter' => function() use (&$counter) {
                $counter += 1; 
                return $counter;
            }
         ),
        array( 'db' => 'name','dt' => 1 ),
        array( 'db' => 'email','dt' => 2 ),
        array( 
            'db' => 'view',
            'dt' => 3,
            'formatter' => function($view){
                return $view == 0? "unread" : "read";
            }
        ),
        array( 
            'db' => 'id',
            'dt' => 4,
            'formatter' => function($id){
              
                return "<button class='btn btn-primary btn-icon-split view-button' id ='$id' ><span class='icon text-white-50'><i class='fas fa-flag'></i></span><span class='text'>View</span></button>";
            }
        ),   array( 
            'db' => 'id',
            'dt' => 5,
            'formatter' => function($id){
              
                return "<button data-id='$id' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash' /></button>";
            }
        ) 
        
        // delete product return "<a data-id='$id' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash' /></a>
    );

    $sql_details = array(
       'user' => 'root',
        'pass' => '',
        'db'   => 'ecommerce2',
        'host' => 'localhost'
        // ,'charset' => 'utf8' // Depending on your PHP and MySQL config, you may need this
    );

    require('../DataTables-master/examples/server_side/scripts/ssp.class.php');
    echo json_encode(
        SSP::simple( $_GET, $sql_details, $table, $primaryKey, $columns )
    ); 