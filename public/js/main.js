//parameter n - reprsents the table column to get the td tag from 
function sortTableByLetters(n) {
  
  //declare and initialise varaibles 
  var mytable = document.getElementById("myTable");
  var swtichBool = true; //bool to continually repeat checking over the table 
  var tableRows, i, x, y;
  var shouldSwitch;		//bool to handle swapping of elements
  

  /* While loop until no swtich is made */
  while (switchBool == true) {
    //set swtich to false 
    switchBool = false;
    tableRows = mytable.rows;
  
    //Loop through all table rows
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements to compare*/
      x = rows[i].getElementsByTagName("TD")[n];		//current row
      y = rows[i + 1].getElementsByTagName("TD")[n];	//next row
      
    	//check if x value is greater than y
      if (x.innerHTML.toLowerCase() > y.innerHTML.toLowerCase()) {
         //preform a swtich bool to true
        shouldSwitch = true;
        break;
      }
    }
  	//if switch is true then swap elements
    if (shouldSwitch == true) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switchBool = true;
    }
  }
}

//parameter n - reprsents the table column to get the td tag from 
function sortTableByDate(n) {
   
  //declare and initialise varaibles 
  var mytable = document.getElementById("myTable");
  var swtichBool = true; //bool to continually repeat checking over the table 
  var tableRows, i, x, y;
  var shouldSwitch;		//bool to handle swapping of elements
  

  /* While loop until no swtich is made */
  while (switchBool == true) {
    //set swtich to false 
    switchBool = false;
    tableRows = mytable.rows;
  
    //Loop through all table rows
    for (i = 1; i < (rows.length - 1); i++) {
      //start by saying there should be no switching:
      shouldSwitch = false;
      /*Get the two elements to compare*/
      x = rows[i].getElementsByTagName("TD")[n];		//current row
      y = rows[i + 1].getElementsByTagName("TD")[n];	//next row
      
    	//check if x value is greater than y
      if (x.innerHTML> y.innerHTML) {
        //preform a swtich bool to true
        shouldSwitch = true;
        break;
      }
    }
  	//if switch is true then swap elements
    if (shouldSwitch == true) {
      rows[i].parentNode.insertBefore(rows[i + 1], rows[i]);
      switchBool = true;
    }
  }
}

//parameter n - reprsents the table column to get the td tag from 
//parameter name - reprsents the id of the input html element
function mysearchFunction(n,name){
 // Declaring variables
  var input = document.getElementById(name);
  var filter = input.value.toUpperCase();
  var mytable = document.getElementById("myTable");
  var tableRow = table.getElementsByTagName("tr");
  var td, i, txtValue;
  

  // Loop through all table rows, and hide those who don't match the search query
  for (i = 0; i < tableRow.length; i++) {
    td = tableRow[i].getElementsByTagName("td")[n];
    //if there exists a table data, then fetch the text value within the td tag 
  	if (td) {
      txtValue = tableRow.textContent || tableRow.innerText;
      
    	//uses indexof to compare the string of the td value to the input string
    	if (txtValue.toUpperCase().indexOf(filter) > -1) {
        //display the td element
        tr[i].style.display = "";
      } else {
      //else hide the td element
        tr[i].style.display = "none";
      }
    }
  }
}

//paramter name - is the name file
function displayFileName(name) {

//set a html element with matching id to "filename" value, to the name of the file 
document.getElementById("filename").innerHTML = name;
}