<?php
   include 'connection.php';

   $counter = 0;
// DB table to use
$table = 'products';
    
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
        array( 'db' => 'price','dt' => 2 ),
        array( 
            'db' => 'image',
            'dt' => 3,
            'formatter' => function($imageSrc,$row){
                return "<a> <img src='img/$imageSrc' style='width:70px; height: 70px;'/> </a>";
            }
        ),
        array( 
            'db' => 'describtion',
            'dt' => 4,
            'formatter' => function($describtion,$row){
                $shownDescribition=substr($describtion,0,20);
                return "<span title='$describtion' >$shownDescribition</span>";
            }
        ),array(
            'db' => 'brand_id',  // Use the 'id' field for the operation
            'dt' => 5,      // Assign a new column index
            "formatter" => function ($brandId, $row) use($connection) {
                $selectBrand = $connection -> query("SELECT * FROM brands WHERE id = $brandId");
                $brand = $selectBrand->fetch_assoc();
                return $brand["name"];

            }
        ),
        array(
            'db' => 'category_id',  // Use the 'id' field for the operation
            'dt' => 6,      // Assign a new column index
            "formatter" => function ($categoryId, $row) use($connection) {
                $selectCat = $connection -> query("SELECT * FROM categories WHERE id = $categoryId");
                $Category = $selectCat->fetch_assoc();
                return $Category["name"];

            }
            ), 
            array( 'db' => 'count','dt' => 7 ),
            array( 
                'db' => 'sale',
                'dt' => 8,
                "formatter" => function ($sale, $row)  {
                    return $sale > 0 ?"$sale%" : "No sale" ;
                }
             ),
            array( 
                'db' => 'new'
                ,'dt' => 9,
                "formatter" => function ($new, $row)  {
                    return $new == 0 ? "<h6><span class='badge badge-secondary p-2'>Old</span></h6>" : "<h6><span class='badge badge-primary p-2'>New</span></h6>" ;
                }
             ),
            array( 
                'db' => 'rate',
                'dt' => 10,
                "formatter" => function ($rate, $row)  {
                    return "$rate <sapn class='text-warning'>Stars</sapn>" ;
                }
            ),
            array( 'db' => 'id',
            'dt' => 11,
            "formatter" => function ($id, $row)  {
                return "<a href='?action=productImages&id=$id' type='button' class='btn btn-outline-info'>Images</a>" ;
            }

        ), // other images
            array( 
                'db' => 'id',
                'dt' => 12,
                "formatter" => function ($id, $row)  {
                    return "<a href='?action=editProduct&id=$id' class='btn btn-success btn-circle hvr-wobble-to-top-right'> <i class='fas fa-pen'></i> </a>" ;
                }
            
            ), // edit product
            array( 
                'db' => 'id',
                'dt' => 13,
                "formatter" => function ($id, $row)  {
                    return "<a data-id='$id' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash'/></a>" ;
                }              
            ), // delete product return "<a data-id='$id' class='btn btn-danger btn-circle deleteButton hvr-buzz'><i class='fas fa-trash' /></a>
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