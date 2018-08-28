<?php
require("model.php");
getJoinedGroup();
echo "<br/>"."function test page from vm";
echo " <a href='https://accounts.google.com/logout'>logout</a>";
if(checkLogin()=="true"){
  echo '<form action="control.php" method="post">
  get all file name id mimetype
<input type="submit" name="act" value="getlist"><br/>

  explorer 
  
<input type="hidden" name="pId" value="root">
<input type="submit" name="act" value="getFolderList"><br/>
  
  get shared folder list 
<input type="submit" name="act" value="getShared"><br/>
  
  get member list by searh "member input" sheet file in root dir
<input type="submit" name="act" value="getMemberList"><br/>
  
  check if year folder exist, if not exist -> create
<input type="submit" name="act" value="checkYearFolderExist"><br/>
  
  check if position folder exist, if not exist -> create
<input type="submit" name="act" value="checkPositionFolderExist"><br/>

  append data to member sheet<br/>
  name
<input type="text" name="name" value=""><br/>
email
<input type="text" name="email" value=""><br/>
phone
<input type="text" name="phone" value=""><br/>
position
<input type="text" name="position" value=""><br/>
year
<input type="text" name="year" value="104"><br/>
<input type="submit" name="act" value="appendData"><br/>  

  create google file
<input type="submit" name="act" value="createFile"><br/>

  create separate permission under a folder
<input type="submit" name="act" value="separatePermission"><br/>
  get apache run-charc in process
<input type="submit" name="act" value="whoami"><br/>
<iframe src="https://calendar.google.com/calendar/embed?title=Test%20calendar&amp;showTabs=0&amp;showTz=0&amp;height=400&amp;wkst=2&amp;bgcolor=%23666666&amp;src=junanbackup%40gmail.com&amp;color=%231B887A&amp;ctz=Asia%2FTaipei" style="border-width:0" width="400" height="400" frameborder="0" scrolling="no"></iframe></form>';
}else{
  header('Location: index.php');
}
?>

