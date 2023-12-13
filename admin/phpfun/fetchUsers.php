<?php
    
    $counter = 0;
// DB table to use
$table = 'users';
    
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
        array( 'db' => 'fullname','dt' => 1 ),
        array( 'db' => 'email','dt' => 2 ),
        array( 
            'db' => 'gender_id',
            'dt' => 3,
            'formatter' => function($genderId,$row){
                return $genderId == 1 ? "male" : "female";
            }
        ),
        array( 
            'db' => 'permission_id',
            'dt' => 4,
            'formatter' => function($permissionId,$row){
                return $permissionId == 3 ? "user" : "Blocked";
            }
        ),array(
            'db' => 'id',  // Use the 'id' field for the operation
            'dt' => 5,      // Assign a new column index
            'formatter' => function ($id, $row) {
                return "<a data-id='$id' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash' /></a>";
            }
        ),
        array(
            'db' => 'id',  // Use the 'id' field for the operation
            'dt' => 6,      // Assign a new column index
            'formatter' => function ($id, $row) {
                $permissionId = $row['permission_id'];
                if($permissionId == 3){
                    return "<a href='phpfun/blockuser.php?id=$id' class='btn btn-warning btn-icon-split hvr-bounce-out'><span class='icon text-white-50'><i class='fas fa-exclamation-triangle'></i></span><span class='text'>Block User</span></a>";
                }else{
                    return "<a href='phpfun/removeblock.php?id=$id' class='btn btn-success  btn-icon-split hvr-bounce-out'><span class='icon text-white-50'><i class='fas fa-info-circle'></i></span><span class='text'>Remove Block</span></a>";
                }
            }
        )
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