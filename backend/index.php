<?php 
// this will be your backend
// some things this file should do
// get query string 
// handle get requests
// open and read data.csv file
// handle post requests
// (optional) write to csv file. 
// format data into an array of objects 
// return all data for every request. 
// set content type of response.
// return JSON encoded data

header('Content-Type: application/json');
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With");

 
$filename = "data.csv"; //  CSV file

// Function to read the CSV file and return an array of data
function read_csv() {
    global $filename;
    $data = array();
    if (($handle = fopen($filename, "r")) !== FALSE) {
        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $data[] = $row;
        }
        fclose($handle);
    }
    return $data;
}

// Function to write data to the CSV file
function write_csv($data) {
    global $filename;
    if (($handle = fopen($filename, "w")) !== FALSE) {
        foreach ($data as $row) {
            fputcsv($handle, $row);
        }
        fclose($handle);
    }
}

// Function to get a single row of data by ID
function get_row_by_id($id) {
    $data = read_csv();
    foreach ($data as $row) {
        if ($row[0] == $id) {
            return $row;
        }
    }
    return null;
}

// Function to insert a new row of data
function insert_data($data) {

    // sort array as required in csv  
    $sortarray=array();
    $sortarray['name']=$data['name'];
    $sortarray['state']=$data['state'];
    $sortarray['zip']=$data['zip'];
    $sortarray['amount']=$data['amount'];
    $sortarray['qty']=$data['qty'];
    $sortarray['item']=$data['item'];

    // Generate a unique ID for the new row
    $counter = 1;
    $random_number = mt_rand(1000, 9999);

    // Add the counter to the random number
    $auto_increment_number = $random_number . $counter;

    // Increment the counter for the next number
    $counter++;

    array_unshift($sortarray, $auto_increment_number); // Add the ID to the beginning of the data array
    $rows = read_csv();
    $rows[] = $sortarray;
    write_csv($rows);
}

// Function to update an existing row of data
function update_data($id, $data) {
    $rows = read_csv();
    foreach ($rows as $key => $row) {
       // echo $key;
        if ($row[0] == $id) {
            array_splice($rows, $key, 1, array($data));
            write_csv($rows);
            return true;
        }
    }
    return false;
}

// Function to delete a row of data by ID
function delete_data($id) {
    $rows = read_csv();
    foreach ($rows as $key => $row) {
        if ($row[0] == $id) {
            array_splice($rows, $key, 1);
            write_csv($rows);
            return true;
        }
    }
    return false;
}

// Handle the REST API requests

// Get All data/single data by id 
if ($_SERVER["REQUEST_METHOD"] == "GET") {
        if (isset($_GET["id"])) {
        $row = get_row_by_id($_GET["id"]);
        if ($row) {
        echo json_encode($row);
        } else {
        http_response_code(404);
        echo json_encode(array('code'=>'404', 'message'=>'Row not found'));
        }
        } else {
        $data = read_csv();
        $count=count($data);
        $row =array();
        $rowdata=array();
        $headercol=array();
        $colm=array();
        for($i=0; $i<$count; $i++){
        $jcount=count($data[$i]);
        for ($j = 0; $j < $jcount; $j++) {
        $header= $data[0][$j];
        // header column 
        if($i==0){ 
        $headercol['headerName']= $data[0][$j];
        $headercol['field']= $data[0][$j];
         $colm[]=$headercol;
        }

        // row data 
        if($i>0){ 
        $row[$header]=$data[$i][$j];
        }  
        }
        if($i>0){
        $rowdata[]=$row;
        }
        }
        http_response_code(200);
        echo json_encode(array('code'=>'200', 'message'=>'Get all data', 'data'=>$rowdata, 'headerdata'=>$colm));
        }
} elseif ($_SERVER["REQUEST_METHOD"] == "POST") {
    $put_data = file_get_contents('php://input');
    
    // Parse the PUT data as JSON
    $data = json_decode($put_data, true);

    /// update data 
   if(isset($data['id']) && isset($data['name'])){
    $id = $data['id'];
      $name = $data['name'];
      $state = $data['state'];
      $zip = $data['zip'];
      $amount = $data['amount'];
      $qty = $data['qty'];
      $item = $data['item'];
  
      if (update_data($id, $data)) {
            $alldata = read_csv();
          echo json_encode(array('code'=>'200', 'message'=>'Row updated', 'data'=>$alldata));
      } else {
          echo json_encode(array('code'=>'404', 'message'=>'Row not updated'));
      }

   } 
   // Delete data
   else if(isset($data['id']) && empty($data['name'])){  
    delete_data($data['id']);
    $alldata = read_csv();
    echo json_encode(array('code'=>'204', 'message'=>'Row deleted succesfully', 'data'=>$alldata));
    } 
    //  Insert data 
    else{
        $name = $data['name'];
        $state = $data['state'];
        $zip = $data['zip'];
        $amount = $data['amount'];
        $qty = $data['qty'];
        $item = $data['item'];
        $id = insert_data($data);  // insert data function call 
        $alldata = read_csv();
        if($alldata){
            echo json_encode(array('code'=>'201', 'message'=>'Data inserted succesfully', 'data'=>$alldata));
        } else{
            echo json_encode(array('code'=>'404', 'message'=>'Somthing wrong'));
        }
       
    }


    
    //echo $id;
} 
  else {
    echo json_encode(array('code'=>'404', 'message'=>'Unknown method'));
}



?>