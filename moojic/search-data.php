<?php

    /* Database setup information */
    $dbhost = 'localhost';  // Database Host
    $dbuser = 'root';       // Database Username
    $dbpass = 'root';           // Database Password
    $dbname = 'moojicwebapp';     // Database Name

    /* Connect to the database and select database */
    $conn = mysql_connect($dbhost, $dbuser, $dbpass) or die(mysql_error());
    mysql_select_db($dbname);
    /* The search input from user ** passed from jQuery .get() method */
    $param = $_GET["searchData"];                  /* If connection to database, run sql statement. */
     if ($conn) {

        /* Fetch the users input from the database and put it into a
         valuable $fetch for output to our table. */
        $fetch = mysql_query("SELECT * FROM restaurant WHERE restaurant_name REGEXP '^$param|$param' OR address REGEXP '^$param|$param' ");

        /*
           Retrieve results of the query to and build the table.
           We are looping through the $fetch array and populating
           the table rows based on the users input.
         */
    $sResults="";
        while ( $row = mysql_fetch_object( $fetch )) {
            $url= "http://46.137.213.123/moojic-webapp/moojic1/moojic-new/bootstrap-playlist.php?cafeid=".$row->restaurant_name;
            $sResults .= '<tr  url="'.$url.'" id="'.$row->restaurant_name.'">';

             $sResults .= '<td style="padding-left:10%;letter-spacing:1px;font-size:20px;color:#0080FF;">' . $row->restaurant_name . '<span class="desc">'.$row->address.' '.$row->contact.'</span></td>';
            
            $sResults .= '</tr>';
        }

    }

    /* Free connection resources. */
    mysql_close($conn);

    /* Toss back the results to populate the table. */
    echo $sResults;

?>
