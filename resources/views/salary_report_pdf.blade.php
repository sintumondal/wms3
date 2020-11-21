<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Salary Report</title>

    <style>
#customers {
  font-family: Arial, Helvetica, sans-serif;
  border-collapse: collapse;
  width: 80%;
}

#customers td, #customers th {
  border: 1px solid #ddd;
  padding: 6px;
}

#customers tr:nth-child(even){background-color: #f2f2f2;}

#customers tr:hover {background-color: #ddd;}

#customers th {
  padding-top: 9px;
  padding-bottom: 9px;
  text-align: left;
  background-color: #4CAF50;
  color: white;
}
</style>

    <style>
        .container {
            width: 90%;
            margin: auto;
            /* background: red; */
        }
        
        .header-img {
            width: 80px;
            height: auto;
        }
        
        .header {
            text-align: center;
        }
        
        .header-text {
            text-transform: uppercase;
            margin: 0px;
            padding: 0px;
        }
        
        .floattopright {
            float: right;
        }
        
        .floattopright_category {
            float: right;
            padding: 2px;
            border: 1px solid black;
        }
        
        .floattopleft {
            float: left;
        }
        
        .footer {
            text-align: center;
            border-top: 1px solid black;
        }
        
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            margin: 0px;
            padding: 0px;
        }
        
        .bodytitle {
            text-align: center;
        }
        
        .body {
            text-align: justify;
        }
        
        .signature {
            text-align: right;
        }
    </style>
</head>

<body>
    <div class="container">
        <div class="header">
           
          
            <h3 class="header-text">Goverment Of West Bengal</h3>
            <h3 class="header-text">Office Of The District Magistrate</h3>
            <h3 class="header-text">Purba Barddhaman 713101</h3>
        </div>
        <div class="body">
            <div class="floattopleft"><b></b></div>
            <div class="floattopright"> <b></b></div>
           
            <h3 class="bodytitle"></h3>
            <br><br><br><br><br>


            <table id="customers" class="table table-bordered">
                <thead>

                    <?php foreach ($table_head as $key => $value) { ?>
                        <tr>
                      <?php  foreach ($value as $key => $value1) { ?>
                       
                        <th>{{$value1}} </th>
                        <?php } ?>
                    </tr>
                       
                  <?php  } ?>
                  
                </thead>
                <tbody>
                   
                    <?php foreach ($table_data as $key => $value2) { ?>
                        <tr>
                      <?php  foreach ($value2 as $key => $value3) { ?>
                       
                        <td>{{$value3}} </td>
                        <?php } ?>
                    </tr>
                       
                  <?php  } ?>
                </tbody>
            </table>
         
    
                
        </div>
        
    </div>


</body>
</html>