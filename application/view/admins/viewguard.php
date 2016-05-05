<?php

if(!isset($_SESSION)) 
    { 
        session_start(); 
    } 
if(!isset($_SESSION['admin_id']))
{
	header('location: '.URL. 'admins/login');
	die();
}
?>

<div class="container">
	
	<h3>Pending Appointments: </h3>
	
	<?php	
	require APP. 'view/_templates/_appointmentTableHeader.php';
	$pendingAppointments= $this->model->getPendingAppointments();
	
	foreach($pendingAppointments as $appointment)
	{
		
		 echo "<tr>";
        
      echo "<td>";
          if (isset($appointment->InmateId)) 
          {
            
          $inmateId=$appointment->InmateId;
          $sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
          $query = $this->db->prepare($sql);
          $query->bindValue(':inmateId',$inmateId);
          $query->execute();
          $inmate = $query->fetch(PDO::FETCH_ASSOC);
          
          echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
          $InstId=$inmate['InstId'];
          } 
        echo" </td>";
        
        echo"<td>"  ;
          $sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
          $query = $this->db->prepare($sql);
          $query->bindValue(':InstId',$InstId);
          $query->execute();
          
          $Institution = $query->fetch(PDO::FETCH_ASSOC);
          echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
          echo ", ";
          echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
                    
            echo"</td>"; 
        
             echo"<td>";
          if (isset($appointment->VisitorId)) 
          {
			 
			 $VisitorId=$appointment->VisitorId;
          $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId ";
          $query = $this->db->prepare($sql);
          $query->bindValue(':VisitorId',$VisitorId);
          $query->execute();
          
          $Visitor = $query->fetch(PDO::FETCH_ASSOC);
          echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
                           
         echo " </td>";
        
        
        
            echo"<td>";
              
          if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
          {
          
          echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
          } 
          else echo "NOT PRESENT";
          
                        
          echo  "</td>";
        
        echo"<td>";
              
          if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
          {
          echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
          }
          else echo "NOT PRESENT";
               
            echo"</td>";
        
      echo  "<td>";
              if (isset($appointment->DateOfAppointment)) 
              echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
           
         echo"<td>";
               if (isset($appointment->TimeOfAppointment)) 
              echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
         } 
        
		
		
	
	?>
	<td>
		<a href="<?php echo URL . 'appointments/approve/' . $appointment->Id; ?>">Approve</a>
		<a href="<?php echo URL . 'appointments/reject/' . $appointment->Id; ?>">Reject</a>
	</td>
	</tr>
	<?php
	
	}
	?>
	</tbody>      
	</table>
	
	
	<h3>Future Appointments: </h3>
	
	<?php	
	
	$appointments =$this->model->getApprovedAppointments();
	require APP. 'view/_templates/_appointmentTableHeader.php';
	
	
	
	foreach($appointments as $appointment)
	{
		
		 echo "<tr>";
        
      echo "<td>";
          if (isset($appointment->InmateId)) 
          {
            
          $inmateId=$appointment->InmateId;
          $sql="SELECT FirstName, LastName, InstId FROM inmates WHERE Id=:inmateId";
          $query = $this->db->prepare($sql);
          $query->bindValue(':inmateId',$inmateId);
          $query->execute();
          $inmate = $query->fetch(PDO::FETCH_ASSOC);
          
          echo htmlspecialchars($inmate['FirstName'], ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($inmate['LastName'], ENT_QUOTES, 'UTF-8');
          $InstId=$inmate['InstId'];
          } 
        echo" </td>";
        
        echo"<td>"  ;
          $sql="SELECT Name, Location FROM institutions WHERE Id=:InstId";
          $query = $this->db->prepare($sql);
          $query->bindValue(':InstId',$InstId);
          $query->execute();
          
          $Institution = $query->fetch(PDO::FETCH_ASSOC);
          echo htmlspecialchars($Institution['Name'], ENT_QUOTES, 'UTF-8'); 
          echo ", ";
          echo htmlspecialchars($Institution['Location'], ENT_QUOTES, 'UTF-8');
                    
            echo"</td>"; 
        
             echo"<td>";
          if (isset($appointment->VisitorId)) 
          {
			 
			 $VisitorId=$appointment->VisitorId;
          $sql="SELECT FirstName, LastName FROM visitors WHERE Id=:VisitorId ";
          $query = $this->db->prepare($sql);
          $query->bindValue(':VisitorId',$VisitorId);
          $query->execute();
          
          $Visitor = $query->fetch(PDO::FETCH_ASSOC);
          echo htmlspecialchars($Visitor['FirstName'], ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($Visitor['LastName'], ENT_QUOTES, 'UTF-8');
                           
         echo " </td>";
        
        
        
            echo"<td>";
              
          if (isset($appointment->Visitor2FirstName)&&isset($appointment->Visitor2LastName)) 
          {
          
          echo htmlspecialchars($appointment->Visitor2FirstName, ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($appointment->Visitor2LastName, ENT_QUOTES, 'UTF-8');
          } 
          else echo "NOT PRESENT";
          
                        
          echo  "</td>";
        
        echo"<td>";
              
          if (isset($appointment->Visitor3FirstName)&&isset($appointment->Visitor3LastName)) 
          {
          echo htmlspecialchars($appointment->Visitor3FirstName, ENT_QUOTES, 'UTF-8'); 
          echo " ";
          echo htmlspecialchars($appointment->Visitor3LastName, ENT_QUOTES, 'UTF-8');
          }
          else echo "NOT PRESENT";
               
            echo"</td>";
        
      echo  "<td>";
              if (isset($appointment->DateOfAppointment)) 
              echo htmlspecialchars($appointment->DateOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
           
         echo"<td>";
               if (isset($appointment->TimeOfAppointment)) 
              echo htmlspecialchars($appointment->TimeOfAppointment, ENT_QUOTES, 'UTF-8'); 
           echo "</td>";
         } 
        
		
		
	
	?>
	<td>
		<a href="<?php echo URL . 'appointments/show/' . $appointment->Id; ?>">View</a>
	
	</td>
	</tr>
	<?php
	
	}
	?>
	</tbody>      
	</table>
	
</div>