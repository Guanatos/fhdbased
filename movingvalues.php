<html>
    <head>
        <title>Move Options Between Two Select Boxes And Save Changes To Database</title>
        <!– include some style –>
        <link rel=”stylesheet” type=”text/css” href=”css/style.css” />
    </head>
<body>
<?php
//connect to database
include ‘db_connect.php’;

//if the form was submitted
if( $_POST ){

    //delete previously assigned locations
    //in this example, type = 2 means “location”
    $sql = “delete from assigned_objects where type = 2″;
    
    //execute the sql
    if( $mysqli->query( $sql ) ){
    
        //if the query was executed successfully
        //save newly assigned names
        //$_POST[‘location_right’] is the select box on the right side
        foreach( $_POST[‘location_right’] as $value ){
            
            //write save query
            $sql = “insert into assigned_objects ( type, object_id ) 
                        values( 2, “ . $mysqli->real_escape_string( $value ) . ” )”;

            //execute save sql query
            if( !( $mysqli->query( $sql ) ) ){
                
                //if the query execution was unsuccessful
                echo “<div>Database Error: Unable to insert record.</div>”;
            }
            
        }
        
    }else{
        //if unable to delete previously assigned locations
        echo “<div>Database Error: Unable to delete assigned locations.</div>”;
    }
    
}

//get ids of currently assigned locations 
$sql = “select * from assigned_objects where type = 2″;
$result = $mysqli->query( $sql );

if( $result ){
    
    //$location_in will be our variable to accumulate currently assigned locations ids
    //example value will be “46, 49, 51″, 
    //which will be used to exempt currently assigned locations (right select box) 
    //to available locations list (left select box)
    $location_in = “”;
    
    //get number of rows found
    $num = $result->num_rows;
    
    if( $num ){ //if there are assigned locations in the database
    
        //set $x to 1, the first loop
        $x = 1;
        
        while( $row = $result->fetch_assoc() ){ //loop the accumulate values
        
            //object_id is actually the location id
            $location_in .= $row[‘object_id’];
            
            //when $x is less than the total number of rows, append a comma
            //else, do not append a comma
            if( $x < $num ){
                $location_in .= “, “;
            }
            
            //increment $x
            $x++;
        }
        
    }

}else{
    //when there’s an error selecting the assigned locations
    echo “Database Error: Unable to select assigned locations.”;
}

?>

<div>

<!–
    here on our form, the onsubmit value is very important,
    it will select all the values in the location_right select box,
    which is to be saved in the database.
    see the javascript section for details about selectAll()
–>
<form action=’index.php’ method=’post’ onsubmit=”return selectAll( new Array( ‘location_right’ ) );”>

    <!– left select box –>
    <div class=’select_box’>
        <div class=’select_title’>Available Locations</div>
        <div style=’clear:both;’></div>
        <select name=’location_left’ id=’location_left’ size=’7′ multiple=’multiple’>
            <?php
            
            if( $location_in ){ //if $location_id has a value, there are location ids to be exempted
                $sql = “select * from locations where id not in ( {$location_in} ) order by name”; 
            }else{
                //else, select all locations
                $sql = “select * from locations”; 
            }
            
            $result = $mysqli->query( $sql );

            if( $result ){
                //if it returns a result, loop through it with options tag
                while( $row = $result->fetch_assoc() ){
                    echo “<option value=’{$row[‘id’]}‘>{$row[‘name’]}</option>”;
                }
            }
            ?>
        </select>
    </div>

    <!– direction move buttons –>
    <div class=’btn’>
        <!– option move to right button –>
        <button type=”button” onclick=”move( ‘location_left’, ‘location_right’ )”> > </button>
        <br />
        <!– option move to left button –>
        <button type=”button” onclick=”move( ‘location_right’, ‘location_left’ )”> < </button>
    </div>

    <!– right select box –>
    <div class=’select_box’>
        <div class=’select_title’>Assigned Locations</div>
        <div style=’clear:both;’></div>
        <select name=’location_right[]’ id=’location_right’ size=’7′ multiple=’multiple’>
        
            <?php       
            //query joining assigned_objects and locations table
            //so we can easily get the location_name
            $sql = “select
                        l.id as location_id, 
                        l.name as location_name 
                    from 
                        assigned_objects ao, locations l
                    where 
                        ao.type = 2 
                        and ao.object_id in ( {$location_in} )
                        and ao.object_id = l.id”;
                    
            $result = $mysqli->query( $sql );

            if( $result ){
                //if query successful, loop through the values with option tag
                //so it will show up in the select list
                while( $row = $result->fetch_assoc() ){
                    
                    echo “<option value=’{$row[‘location_id’]}‘>{$row[‘location_name’]}</option>”;
                
                }
            }
            
            ?>
        </select>
        
    </div>
    
    <div style=’clear:both;’></div>
    <input type=’submit’ value=’Save’ />
    
</form>

<script type=’text/javascript’>
//this function will select all the values of the right select box, so you can post it
//this function can accept array of select boxes with id as its reference
function selectAll( obj_arr ){

    var obj_sel;
    for ( var i = 0; i < obj_arr.length; i++ ){
    
        obj_sel = document.getElementById( obj_arr[i] );
        
        for( var j = 0; j < obj_sel.options.length; j++ ){
            obj_sel.options[j].selected = true;
        }
        
    }
    
}

function move( id_1, id_2 ){
        
        //the box where the value will come from
        var opt_obj = document.getElementById( id_1 );
        
        //the box where the value will be locationd
        var sel_obj = document.getElementById( id_2 );
        
        for ( var i = 0; i < opt_obj.options.length; i++ ){ //loop to check for multiple selections
                
                if ( opt_obj.options[i].selected == true ){ //check if the option was selected
                        
                        //value to be transfered
                        var selected_text = opt_obj.options[i].text;
                        var selected_value = opt_obj.options[i].value;
                        
                        //remove from opt
                        opt_obj.remove( i );
                        
                        //decrease value of i since an option was removed 
                        //therefore the opt_obj.options.length will also decrease
                        i–;
                        
                        //process to sel
                        var new_option_index = sel_obj.options.length;
                        sel_obj.options[new_option_index] = new Option( selected_text, selected_value );
                        
                }
                
        }
}
        
</script>

</body>
</html>
