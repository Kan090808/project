<?php
$email = $_REQUEST['email'];
$groupId = $_REQUEST['groupId'];
echo "Welcome to XXX group";
echo "<br/>fill in your personal data";
// echo $groupId;
echo "<br/>";
echo "
	<form method='post' action='control.php'>
	  <input type='hidden' name='act' value='newMemberDetail'><br/>
	  name <input type='text' name='name' value=''><br/>
	  id <input type='text' name='id' value=''><br/>
	  email <input type='text' name='email' value='".$email."' readonly><br/>
	  gender <input type='radio' name='gender' value='male'> male
	  		<input type='radio' name='gender' value='female'> female<br/>
	  class <select name='class' size='3' multiple>
			    <option value='IM'>IM</option>
			    <option value='ECO'>ECO</option>
			    <option value='FINANCIAL'>FINANCIAL</option>
			    <option value='HAPPYHAPPY'>HAPPYHAPPY</option>
		  </select><br/>
	departMent <select name='department' size='3' multiple>
			    <option value='BIG'>BIG</option>
			    <option value='SUO'>SUO</option>
			    <option value='BO'>BO</option>
		  </select><br/>
	  year <select name='year' size='4' multiple>
			    <option value='1'>1</option>
			    <option value='2'>2</option>
			    <option value='3'>3</option>
			    <option value='4'>4</option>
			    <option value='f'>other</option>
		  </select><br/>
	  tel <input type='number' name='tel' value=''><br/>
	  diet <input type='radio' name='diet' value='meat'> meat
	  		<input type='radio' name='diet' value='vegatarian'> vegatarian<br/>
	  skill <input type='text' name='skill' value=''><br/>
	  perfer <input type='text' name='prefer' value=''><br/>
	  <input type='hidden' name='groupId' value='".$groupId."'>
	  <input type='submit' value = 'Apply to join this Group'><br/>
	</form>";

?>