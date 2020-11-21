<!DOCTYPE html>
<html>
    <head>
        <title>Monthly Salary Slip</title>
        <style>
            .content{
                width: 90%;
                margin: auto;
            }
            .table-bordered {
                border: 1px solid #dee2e6;
            }
            .table-bordered th,
            .table-bordered td {                
                border: 1px solid #dee2e6;
            }
            .table-bordered thead th,
            .table-bordered thead td {
               border-bottom-width: 2px;
            }
            .table-striped tbody tr:nth-of-type(odd) {
                background-color: #007bff0d;
            }
            .table-striped1 tbody tr:nth-of-type(odd) {
                background-color: rgba(0, 0, 0, 0.02);
            }
            .table {
                width: 100%;
                max-width: 100%;
                /*height:900px;*/
                margin-bottom: 1rem;
                background-color: transparent;
            }
            .table th{
                font-size: 10px;
                vertical-align: middle;
                border-collapse: separate;
            }
            .table td {
                padding: 0.75rem;
                padding: 4px;
                font-size: 10px;
                vertical-align: middle;
                border-collapse: separate;
                border-top: 1px solid #dee2e6;
                font-weight:bold;
                
            }
            .table th{
                padding: 3px 3px;
            }
            .table thead th {
                vertical-align: bottom;
                border-bottom: 1px solid #dee2e6;
            }

            .table tbody + tbody {
                border-top: 1px solid #dee2e6;
            }
            .table .table {
                background-color: #fff;
            }
            .table-sm th,
            .table-sm td {
                color:#000;
                font-size: 12px;
            }
        </style>
    </head>    
    <body>
        <div class="heading" >       
            <div class="content">           
            <?php
           
                if (!empty($alldatasalaryslip)) { 
                foreach ($alldatasalaryslip as $key => $value) {
                    //for($i=1;$i<10;$i++){
            ?>
                <table id="tableid" class="table table-bordered table-striped" style="margin-top: 20px;" >
                    <thead>
                      {{--   <tr>
                            <th colspan="6">
                                <h1 style="text-align: center; font-family: 'Arial Black', Gadget, sans-serif"><?php ?></h1>
                            </th>
                        </tr> --}}
                        <tr>
                            <th colspan="6">                               
                                <h3 style="text-align: center; font-family: 'Arial Black', Gadget, sans-serif">189 B.B. GANGULY STREET, KOL- 12</h3>
                            </th>
                        </tr>
                        <tr>
                            <th colspan="6">                               
                                <h3 style="text-align: center; font-family: 'Arial Black', Gadget, sans-serif">PAY SLIP FOR THE MONTH OF <?php echo $month_year_designation['month'].'-'.$month_year_designation['year'];  ?></h3>
                            </th>
                        </tr>                        
                    </thead>
                    <tbody>
                        <tr>
                            <td style="width: 16%;" >NAME:</td>
                            <td style="width: 16%;" ><?php echo $value['Employee Name'] ; ?></td>
                            <td style="width: 17%;" >ID</td>
                            <td style="width: 17%;" ><?php echo $value['Employee ID'] ;?></td>
                            <td style="width: 17%;" >GROSS</td>
                            <td style="width: 17%;" ><?php echo $value['Gross'] ;?></td>
                        </tr>
                        <tr>
                    
                            <td style="width: 16%;" >WORKING DAYS</td>
                            <td style="width: 16%;" ><?php echo $value['Working Days'] ;  ?></td>
                            <td style="width: 17%;" ></td>
                            <td style="width: 17%;" >PRESENT DAYS</td>
                            <td style="width: 17%;" ><?php echo $value['Present Days'] ;   ?></td>
                            <td style="width: 17%;" ></td>
                        </tr>
                        <tr>
                            <td style="width: 16%;" >ABSENT DAYS</td>
                            <td style="width: 16%;" ><?php echo $value['Absent Days'] ;?></td>
                            <td style="width: 17%;" >HOLIDAY</td>
                            <td style="width: 17%;" ><?php echo $value['Holidays'] ;?></td>
                            <td style="width: 17%;" >LEAVE</td>
                            <td style="width: 17%;" ><?php echo $value['Leave'] ;?></td>
                        </tr>
                     
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td colspan="6" style="width: 50%;" >ADDITION</td>
                           {{--  <td colspan="4" style="width: 50%;" >DEDUCTION</td> --}}
                        </tr>
                        
                        <tr>
                            <?php

                            if (array_key_exists("BASIC",$value))
                              {  ?>
                               <td style="width: 20%;" >BASIC</td>
                               <td style="width: 20%;" ><?php echo $value['BASIC'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("HRA",$value))
                              {  ?>
                               <td style="width: 20%;" >HRA</td>
                               <td style="width: 20%;" ><?php echo $value['HRA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("DA",$value))
                              {  ?>
                               <td style="width: 20%;" >DA</td>
                               <td style="width: 20%;" ><?php echo $value['DA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                        </tr>

                         <tr>
                            <?php

                            if (array_key_exists("Gross",$value))
                              {  ?>
                               <td style="width: 20%;" >TOTAL ADDITION</td>
                               <td style="width: 20%;" ><?php echo $value['Gross'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("ww",$value))
                              {  ?>
                               <td style="width: 20%;" >HRA</td>
                               <td style="width: 20%;" ><?php echo $value['HRA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("ww",$value))
                              {  ?>
                               <td style="width: 20%;" >DA</td>
                               <td style="width: 20%;" ><?php echo $value['DA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                        </tr>

                        <tr>
                            <td colspan="6" style="width: 50%;" ></td>
                           {{--  <td colspan="4" style="width: 50%;" >DEDUCTION</td> --}}
                        </tr>

                        <tr>
                            <td colspan="6" style="width: 50%;" >DEDUCTION</td>
                           {{--  <td colspan="4" style="width: 50%;" >DEDUCTION</td> --}}
                        </tr>


                       
                        <tr>
                            <?php

                            if (array_key_exists("PF",$value))
                              {  ?>
                               <td style="width: 20%;" >PF</td>
                               <td style="width: 20%;" ><?php echo $value['PF'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("PTax",$value))
                              {  ?>
                               <td style="width: 20%;" >P-Tax</td>
                               <td style="width: 20%;" ><?php echo $value['PTax'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("ESI",$value))
                              {  ?>
                               <td style="width: 20%;" >ESI</td>
                               <td style="width: 20%;" ><?php echo $value['ESI'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                        </tr>

                         <tr>
                            <?php

                            if (array_key_exists("Ded",$value))
                              {  ?>
                               <td style="width: 20%;" >TOTAL DEDUCTION</td>
                               <td style="width: 20%;" ><?php echo $value['Ded'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("ww",$value))
                              {  ?>
                               <td style="width: 20%;" >HRA</td>
                               <td style="width: 20%;" ><?php echo $value['HRA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                             <?php

                            if (array_key_exists("ww",$value))
                              {  ?>
                               <td style="width: 20%;" >DA</td>
                               <td style="width: 20%;" ><?php echo $value['DA'] ;?></td>
                            <?php }else{ ?>
                                <td style="width: 20%;" ></td>
                               <td style="width: 20%;" ></td>
                            <?php  } ?>

                        </tr>

                         <tr>
                            <td colspan="1" style="width: 17%;" > NET PAYMENT</td>
                            <td colspan="5" style="width: 17%;" ><?php echo $value['Net'] ;?></td>
                        </tr>

                       
                        <tr>
                            <td style="border: 0;" colspan="6" rowspan="3" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                        <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                         <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                         <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                         <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>
                         <tr>
                            <td style="border: 0;" colspan="6" ></td>
                        </tr>

                        <tr>
                            <td colspan="3" style="width: 50%;" >MANAGER HR SIGNATURE:</td>
                            <td colspan="3" style="width: 50%;" >EMPLOYEE SIGNATURE:</td>
                        </tr>

                    </tbody>
                </table>              
                <?php } } ?>
            </div>           
        </div>    
    </body>    
</html>
