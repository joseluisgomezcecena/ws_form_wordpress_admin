<?php
define( 'DB_NAME', 'dbwks5ghjxogf2' );

/** Database username */
define( 'DB_USER', 'ug7rgdkxeegle' );

/** Database password */
define( 'DB_PASSWORD', 'ngl92utpibnw' );

/** Database hostname */
define( 'DB_HOST', 'drcarlosochoa.com' );

/** Database charset to use in creating database tables. */
define( 'DB_CHARSET', 'utf8' );


//connect to database
$connect = mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);
if (mysqli_connect_errno()) {
    echo "Failed to connect to MySQL: " . mysqli_connect_error();
    exit();
}
