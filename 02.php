<?php
$arr=[
    'animal'=>['dog','cat','pig'],
    'fruit'=>['apple','banana','pieapple']
];



$table = array( array("A1", "B1" , "C1"),
                array("A2", "B2" , "B2"),
                array("A3", "B3" , "C3") 
);  

foreach($table as $values){
    echo '<table border="1"><tr>';
    foreach($values as $value){
        echo "<td>$value</td>";
    }
    echo '</tr></table>';
}

foreach ($table as $rows => $row)
{
	echo "<table border='1'><tr>";
	foreach ($row as $col => $cell)
	{
		echo "<td>" . $cell . "</td>";
	}	
echo "</tr></table>";
}	
?>