<?php

//
// Sorting class developed using PHP 7 features which dynamically includes the respective classes based on the selected technique
// 1. Bubble sort (Default)
// 2. Merge sort
// 3. Selection Sort
// 4. What next!?
//
class sort {

  private $default = "bubblesort"; // Default parameter for the sorting
  private $sortarray = array('bubblesort', 'mergesort', 'selectionsort');

  //
  // Check for the type and call the appropriate function / sort file
  // Default: Bubble sort
  //
  function __construct($printresult = "no") {

    //
    // Check if the script is being invoked from CLI and prompt the user
    //
    $validinput = false;
    $input = 0;
    if ($this->isCommandLineInterface()) {
      while (!$validinput) {
        $input = $this->fetchInput();
        if (isset($this->sortarray[$input - 1])) {
          $validinput = true;
        }
        else {
          echo "Invalid input! \n";
  	  echo "------------------------------------------\n";
        }
      }
    }

    $this->executesort($input - 1, $printresult);

  }

  function isCommandLineInterface(): bool{
    return (php_sapi_name() === 'cli');
  }

  function fetchinput(): string{
    echo "Welcome to learn and improve sorting skills!! \n";
    echo "1. Bubble Sort (Default)\n";
    echo "2. Merge Sort\n";
    echo "1. Selection Sort\n";
    return readline("Please select the sorting technique: ");
  }

  function executesort($input, $printresult) {
    //
    // Initialize variables
    //
    $type = ($type)?? $this->sortarray[$input];
    $finished = false;                 // Flag to exit the loop
    $try = 0;                          // Flag to check if the default file is not found (Try only once)

    //
    // Loop until finished
    // TODO: Resuse the recursion for other functionalities?
    //
    while (!$finished) {
      try {
	//
	// Suppressing the include errors as it is being handled explicitly
	// Load the specified sort file, load default if invalid input is given
	//
        if ((@include $type . '.php') === false) {
  	  echo "Required file does not exist: " . $type . ".php \n";

	  if ($try > 0) { 
	    echo "No file found. Exiting script, Bye !!!\n";
	    break;
	  }
	  else {
  	    echo "Rerouting to default file: bubblesort.php \n";
  	    $type = $this->sortarray[0];
	    $try++;
	  }
        }
	else {
	  echo "Routing to file: " . $type . ".php\n";
	  //
	  // Fetch the sorted array and print it
	  //
	  // Begin time
	  $starttime = strtotime("now");

          $sortedarray = sortit();
	  if ($printresult === "yes")
	    echo print_r($sortedarray, true);

	  // End time
	  $finishtime = strtotime("now");

	  //
	  // Function timing report
	  //
	  $timetaken = $finishtime - $starttime;
	  echo $type . " completed !!\n";
	  echo "----- Time taken by " . $type . ": " . $timetaken . " seconds -----\n";

	  //
	  // Set the flag for the script to exit
	  //
	  $finished = true;
	}
      }
      catch (Exception $e) {
        echo "Exception: {$e->getMessage()} \n";
      }
    }
  }
}

//
// Control starts: Initialize the sort class
//
$obj = new sort($argv[1]?? null);

?>
