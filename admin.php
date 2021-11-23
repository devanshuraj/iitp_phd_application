<?php
include ('session.php');
include_once ('dbconn.php');

if ($access == 1) {
     echo '<table align="right">
     <tr>
     <td><table align="right" border = 8><tr><td><a href="logout.php">LOGOUT</a></td></tr></table>
     </table>';

?>
     <html>
     <body>
     <center>
     <h2>Welcome to PhD Admin Portal</h2>
     
          
<?php
     $sql = "SELECT DISTINCT phd_department from `phd_application_info`";
     $result = $db->query($sql);
     $count=0;
     echo '<table border=5><tr><th>S.No.</th><th>Link to Download summary sheets</th></tr>';
     if ($result -> num_rows > 0) {
          while($row = $result->fetch_assoc()) {
                    $count++;
                    $phd_department=$row['phd_department'];
                    echo '<tr><td>'.$count.'</td><td><a href="download.php?phd_department='.$phd_department.'">'.$phd_department.'</a></td>'; 

          }
     } else {
          echo "No Form filled";
     }
     
?>
     </center>
     <br>
     <center>

<?php
     echo '</table>';
     $sql = "SELECT DISTINCT phd_department from `phd_application_info`";
     $result = $db->query($sql);
     $count=0;
     echo '<table border=5><tr><th>S.No.</th><th>Link to Download pdf zip</th></tr>';
     if ($result -> num_rows > 0) {
          while($row = $result->fetch_assoc()) {
                    $count++;
                    $phd_department=$row['phd_department'];
                    echo '<tr><td>'.$count.'</td><td><a href="generate_all_pdf.php?phd_department='.$phd_department.'">'.$phd_department.'</a></td>'; 

          }
     } else {
          echo "No Form filled";
     }
     echo '</table>';
?>


<?php
}
?>


     </center>

     <br>
     <br>
     </body>
     </html>
