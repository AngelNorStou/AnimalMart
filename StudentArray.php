<?php

$students = array("Anna", "Philippe", "John","Heather", "Lisa", "Amber");

echo "List of students whose index is even: ";
echo "<br>";

for ($x = 0; $x < count($students); $x++) 
{
  if(($x % 2) == 0 || $x == 0)
  {
  echo $students[$x];
  echo "<br>";
  }
}
echo "<br>"; 

echo "List of students whose index is odd: ";
echo "<br>";

for ($x = 0; $x < count($students); $x++) 
{
  if( (($x - 1) % 2)  == 0)
  {
  echo $students[$x];
  echo ", ";
  }
}
echo "<br>"; 

echo "List of students in reverse: ";
echo "<br>";

for ($x = count($students) - 1; $x > -1; $x--) 
{

  echo $students[$x];
  echo ", ";
  
}
echo "<br>"; 




?>