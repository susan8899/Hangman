<!DOCTYPE html>
<head>
  <title>Hangman</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
 <link href="test.css" rel="stylesheet" type="text/css" />

</head>
<body id ='content2'>
 <a href= "test.php">Home</a><br><br>
<?php
echo "You have chosen Computer Science";
$Group = "Computer Science";

$item ="DATA
CONNECTION
PROGRAMMING
JAVA
ECLIPSE
NETBEANS
SOFTWARE
HARDWARE
WEB PROGRAMMING
DATA ANALYSIS
DATABASE
EXCEL
MICROSOFT
PROGRAMMER
TECHNOLOGY
ERROR
DEVELOPER
APP DEVELOPMENT
MEMORY
APACHE
ASSEMBLY
BINARY
BOOLEAN
LIBRARY
MAPPING
CLIENT SERVER";
$special_letters = " -.,;!?%&0123456789";

$char = "ABCDEFGHIJKLMNOPQRSTUVWXYZ";
// len_char is equal to the length of $char

// isset() checks whether a variable is set or not
//TRUE if variable exists and has value not equal to NULL

// $_GET gets variable n
$len_char = strlen($char);

if(isset($_GET["num"])) $num=$_GET["num"]; // if the chosen word exists then num gets assigned that chosen word

if(isset($_GET["characters"])) $characters=$_GET["characters"];
// if the letters chosen exist then $characters get assigned that letter

if(!isset($characters)) $characters=""; //if $characters does not exists then $character gets assigned an empty string


#The filename of the currently executing script, relative to the document root. For instance, $_SERVER['PHP_SELF'] in a script at the address 

if(isset($PHP_SELF)) $file=$PHP_SELF;
else $file=$_SERVER["PHP_SELF"];

$hlinks="";


$count=6;  // maximum number of wrong     

$item = strtoupper($item);  //strtoupper converts all characters to uppercase
$s_words = explode("\n",$item); //The explode() function is used to split a   string. Sets the boundary string within the input string



$all_letters=$characters.$special_letters;
$total_wrong = 0;

echo "<p><b>Hangman Game</b> &nbsp;  &nbsp; &nbsp; &nbsp; <b>Subject:  <b>$Group</b><br>\n";

if (!isset($num)) { ///if num does not exist, then n will be assigned to a random word from the list

  $num = rand(1,count($s_words)) - 1; //// between 1 and number of words available, -1
}
$word_line=""; //removes characters/whitespace from both sides of the random word

$c_word = trim($s_words[$num]);
$finish = 1;         // finish is set to 1/true

//Sets up the black spaces for the random word 
for ($a=0; $a < strlen($c_word); $a++)
{
  if (strstr($all_letters, $c_word[$a])) 
    //strstr() function searches for the first occurrence of a string inside another string.
  {
    if ($c_word[$a]==" ") $word_line.="&nbsp; ";  // if a position in word is in $all_letters(all_letters are the letters not in $char) 
    else $word_line.=$c_word[$a];  //  $word_line gets the ath letter in the word ex. ! - is printed instead of __
  } 
  else { 
    $word_line.="_<font size=1>&nbsp;</font>"; //.=,Appends $txt2 to $txt1
    //if a positions is in $char, a __ is created
    $finish = 0;     // finish is set to false, game begins
      
  } 

}

if (!$finish)
{

  for ($c=0; $c<$len_char; $c++)  // if alphabet letter you picked is in the list of letters 
  {
    if (strstr($characters, $char[$c]))  // then the char letter is searched in the random word 
    {
      if (strstr($s_words[$num], $char[$c])) //if it exists the link will change to bold 
      {
        $hlinks .= "\n<b>$char[$c]</b> "; //if char is not in the random word then the link will change to red and $total_wrong will be inc
      }
      else { 
        $hlinks .= "\n<font color=\"red\">$char[$c] </font>"; //if char letter you picked is not in the list of letters then
        //url is changed to include that alpha
         $total_wrong++; 
      }
    
    }
    else
    {
     $hlinks .= "\n<A HREF=\"$file?characters=$char[$c]$characters&num=$num\">$char[$c]</A> "; 
   }
  
  }
  // if you got one wrong then img displays 
  $numwrong=$total_wrong; 

   
  if ($numwrong>6) $numwrong=6;
  echo "\n<p><br>\n<IMG SRC=\"Hangman-$numwrong.png\" ALIGN=\"MIDDLE\" BORDER=0 WIDTH=150 HEIGHT=150 >\n";

//if you use up all your 6 guesses then this displays
  if ($total_wrong >= $count)
  {
    $num++;  //next random word gets inc
    if ($num>(count($s_words)-1)) $num=0;

    echo "<br><br><h1><font size=5>\n$word_line</font></h1>\n";
    echo "<p><br><font color=\"red\"><big>SORRY, YOU ARE HANGED!!!</big></font><br><br>";
    echo "\n<p><br>\n<IMG SRC=\"loser.jpeg\" ALIGN=\"MIDDLE\" BORDER=0 WIDTH=300 HEIGHT=300 >\n";

    if (strstr($c_word, " ")) $term="words"; else $term="word";
    echo "The $term was \"<B>$c_word</B>\"<BR><BR>\n";

    echo "<A HREF=$file?num=$num>Play again.</A>\n\n"; //links Play again link to itsef
  }
  // if you havent used up your 6 guesses, it updates  " number of wrong guesses left:"
  else
  {
    echo " &nbsp; You Have <b>" .($count-$total_wrong). " Guesses Left "."</b><br>\n";
    echo "<h1><font size=5>\n$word_line</font></h1>\n";
    echo "<p><br>Please choose a letter:<br><br>\n";
    echo "$hlinks\n";
  }
}
else  //you got the word right
{
  $num++; # get next word
  if ($num>(count($s_words)-1)) $num=0;
  echo "\n<p><br>\n<IMG SRC=\"great_job.gif\" ALIGN=\"MIDDLE\" BORDER=0 WIDTH=500 HEIGHT=500 >\n";
  echo "<br><br><h1><font size=5>\n$word_line</font></h1>\n";
  echo "<p><br><br><b>Congratulations!!! &nbsp;YOU WON!!!</b><br><br><br>\n";
  echo "<A HREF=$file?num=$num>Play again</A>\n\n";
}
?>
</body>
</html>