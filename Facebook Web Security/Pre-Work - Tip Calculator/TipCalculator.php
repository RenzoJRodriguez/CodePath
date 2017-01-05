<?php
     //Default Values
    $subtotal = 0;
    $percentTip = 15;
    $subtotalValid = false;
    $percentValid = false;
    $splitValid = false;
    $numOfPeople = 1;

    //Function takes in values for subtotal and percentTip, finds the tip amount and rounds it to two decimal places
    function calculateTip($subtotal, $percentTip){
         $tip = $subtotal*($percentTip/100);
         return 'Tip: ' . '$' . round($tip,2);
    }

    //Function takes in values for subtotal and percentTip, finds the total amount and rounds it to two decimal places
    function calculateTotal($subtotal, $percentTip){
         $total = $subtotal + ($subtotal*($percentTip/100));
         return 'Total: ' . '$' . round($total,2);
    }

    //Function determines which value to use as percentTip
    function radioButtons($percent){
              $radioPercents = array(10,15,20);

          //Upon first opening page, the default value will be 15% for the radio buttons
              if(!$_POST){
                   foreach($radioPercents as $value){
                       echo '<input type="radio" name="percentField" class="radioButtons" value="' .$value . '" id="'. $value . '" ';
                            if($percent == $value){
                                 echo 'checked';
                            }
                       echo '><span class="fixedPercents">' . $value . '%</span>';
                  }
                  echo '<br><input type="radio" name="percentField" id="customButton" class="radioButtons">';
              }

              //After a form is submitted, the value of the radio buttons will be retained depending on whether they used the fixed value radio buttons or the custom value radio button
              else if($_POST){
                  //If the fixed value radio buttons are chosen
                   if($_POST['percentField'] == 10 || $_POST['percentField'] == 15 || $_POST['percentField'] == 20 ){
                        foreach($radioPercents as $value){
                            echo '<input type="radio" name="percentField" class="radioButtons" value="' .$value . '" id="'. $value . '" ';
                                 if($_POST['percentField'] == $value){
                                      echo 'checked';
                                 }
                            echo '><span class="fixedPercents">' . $value . '%</span>';
                       }
                       echo '<br><input type="radio" name="percentField" id="customButton" class="radioButtons">';
                   }
                   //If the custom value radio button is chosen
                   else{
                        foreach($radioPercents as $value){
                            echo '<input type="radio" name="percentField" class="radioButtons" value="' .$value . '" id="'. $value . '"><span class="fixedPercents">' . $value . '%</span>';
                       }
                       echo '<br><input type="radio" name="percentField" id="customButton" class="radioButtons" checked="checked">';
                   }
              }

    }

    //Function splits the tip amongst the number of people available and rounds it to two decimal places
    function calculateSplitTip($subtotal, $percentTip, $numOfPeople){
         $splitTip = ($subtotal*($percentTip/100))/($numOfPeople);
         return 'Tip Each: ' . '$' . round($splitTip,2);
    }

    //Function splits the total amongst the number of people available and rounds it to two decimal places
    function calculateSplitTotal($subtotal, $percentTip, $numOfPeople){
              $splitTotal = ($subtotal + ($subtotal*($percentTip/100)))/($numOfPeople);
             return 'Total Each: ' . '$' . round($splitTotal,2);
    }

?>

<!DOCTYPE HTML>
    <html>
         <head>
              <title>Tip Calculator</title>

              <!--Importing Stylesheets for Design -->

                        <!-- Pure CSS Framework -->
                        <link rel="stylesheet" href="https://unpkg.com/purecss@0.6.1/build/pure-min.css" integrity="sha384-CCTZv2q9I9m3UOxRLaJneXrrqKwUNOzZ6NGEUMwHtShDJ+nCoiXJCAgi05KfkLGY" crossorigin="anonymous">

                        <!-- Google Fonts -->
                        <link href="https://fonts.googleapis.com/css?family=Baloo+Thambi" rel="stylesheet" type="text/css">

                        <!-- Font Awesome -->
                        <link href="http://maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" type="text/css">

                        <!-- Custom Stylesheet -->
                        <link href="style.css" rel="stylesheet" type="text/css">

         </head>

         <body id="background">

              <div id="titleBorder" class="readableText">
                   Tip Calculator
              </div>

              <div id="formBorder">
                   <!-- Form for Tip Calculator -->
                   <form  method="post" target="" class="pure-form">

                         <div id="subtotalBorder" class="pure-u-8-24">
                                   <!-- Bill Subtotal & Error Message -->
                                  <span class="subtotalError readableText">
                                       *Bill Subtotal:
                                  </span>

                                  <input type="text" name="subtotalField" placeholder="Bill Subtotal ($)"value="<?php if(isset($_POST['subtotalField'])){print $_POST['subtotalField'];}else{print "";} ?>">
                         </div>

                                                 <!--Form Validation for the subtotal-->
                                                 <?php
                                                     if(!$_POST){
                                                             echo '<br>';
                                                     }
                                                     else if($_POST){
                                                           if(empty($_POST["subtotalField"]) || $_POST["subtotalField"] < 0 || !is_numeric($_POST["subtotalField"])){
                                                                echo '<style>
                                                                      .subtotalError{
                                                                           color: #D92026;
                                                                      }
                                                                </style>';
                                                                echo '<span class="subtotalError">' . "Invalid Subtotal" . '</span>';
                                                           }
                                                           else{
                                                                $subtotal = $_POST["subtotalField"];
                                                                $subtotalValid = true;
                                                                echo '<br>';
                                                           }
                                                      }
                                                 ?>


                         <div id="tipBorder">
                                  <!--Tip Percentage & Error Message-->
                                  <span class="readableText">
                                       *Tip Percentage:
                                  </span><br>

                                  <!--Prints out radio buttons with values-->
                                  <?php
                                             radioButtons($percentTip);
                                  ?>

                                  <span class="customError readableText">Custom: </span><input type="text" placeholder="Custom Tip (%)"name="customInput" id="customText" value="<?php if($_POST){if(isset($_POST['customInput'])&&($_POST['customInput']!="")&&($_POST["percentField"]!=10&&$_POST["percentField"]!=15&&$_POST["percentField"]!=20)){echo $_POST['customInput'];}}?>">
                         </div>

                                  <!--Javascript that makes the custom radio button selected if the textbox is active; Allows user to type into box without having click button every time-->
                                  <script>
                                            document.getElementById("customText").addEventListener("focus", textboxEventHandler);

                                            function textboxEventHandler() {
                                                document.getElementById("customButton").click();
                                            }
                                  </script>

                                  <!--Form Validation for the percentField-->
                                  <?php
                                             if(!$_POST){
                                                  echo '<br>';
                                             }
                                            else if($_POST){
                                                      //If one of the fixedTip options is chosen
                                                      if(($_POST["percentField"] == 10 || $_POST["percentField"] == 15 || $_POST["percentField"] == 20)){
                                                           $percentTip = $_POST["percentField"];
                                                           $percentValid = true;
                                                           echo '<br>';
                                                      }
                                                      //If the customTip option is chosen
                                                      else{
                                                                $customTip = $_POST["customInput"];

                                                                if($customTip <= 0 || !is_numeric($_POST["customInput"])){
                                                                     echo '<style>
                                                                          .customError{
                                                                               color: #D92026;
                                                                          }
                                                                    </style>';
                                                                    echo '<span class="customError">' . "Invalid Custom Tip" . '</span>';
                                                               }
                                                               else{
                                                                    $percentTip = $customTip;
                                                                    $percentValid = true;
                                                                    echo '<br>';
                                                               }
                                                      }
                                            }
                                  ?>


                         <div id="splitBorder" class="pure-u-8-24">
                                  <!--Split Amongst & Error Message-->
                                  <span class="splitError readableText">
                                       Split amongst:
                                  </span>

                                  <!--Box for Splitting Input-->
                                  <input type="text" name="numOfPeople" id="splitBox" value="<?php if(!isset($_POST['numOfPeople'])){echo "1";}if($_POST){if(isset($_POST['numOfPeople'])){echo$_POST['numOfPeople'];}else{echo"1";}}?>">

                                  <span class="splitError readableText">
                                       person(s)
                                  </span>
                         </div>
                                  <!--Form Validation for the split text box input-->
                                  <?php
                                        if(!$_POST){
                                             echo '<br>';
                                        }
                                        else if($_POST){
                                             if(empty($_POST['numOfPeople']) || $_POST['numOfPeople'] < 1 || !is_numeric($_POST['numOfPeople']) || preg_match("/\./",$_POST['numOfPeople'])){
                                                  echo '<style>
                                                        .splitError{
                                                             color: #D92026;
                                                        }
                                                  </style>';
                                                  echo '<span class="splitError">' . "Invalid Split" . '</span>';
                                             }
                                             else{
                                                  $numOfPeople = $_POST['numOfPeople'];
                                                  $splitValid = true;
                                                  echo '<br>';
                                             }
                                        }
                                  ?>


                         <div id="submitBorder">
                                  <!--Submit Button-->
                                  <button type="submit" class="pure-button" id="submitButton">
                                       <i class="fa fa-paper-plane"></i>
                                       submit
                                  </button>
                         </div>

                   </form>

         </div>

               <!-- Prints out the results of calculation -->
              <?php

                   if($_POST){
                        if($percentValid && $subtotalValid && $splitValid){
                             $tip = calculateTip($subtotal, $percentTip);
                             $total = calculateTotal($subtotal, $percentTip);
                             $splitTip = calculateSplitTip($subtotal, $percentTip, $numOfPeople);
                             $splitTotal = calculateSplitTotal($subtotal, $percentTip, $numOfPeople);

                             if($numOfPeople == 1){
                                  echo '<div class="resultBorder readableText">' . $tip . '<br>' . $total . '</div>';
                             }
                             else if($numOfPeople > 1){
                                  echo '<div class="resultBorder readableText">' . $tip . '<br>' . $total . '<br>' . $splitTip . '<br>' . $splitTotal . '</div>';
                             }

                        }
                   }
              ?>

         </body>

    </html>
