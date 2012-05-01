<?php
function quotes(){
$quotes = array();
array_push($quotes,"
          Travel is fatal to
                
                   prejudice, bigotry, and narrow-mindedness.");
array_push($quotes,"
          A ship is safe in the harbor, 
          
                   but that’s not what ships are built for. ");
array_push($quotes,"
          The world is a book 
          
          and those who do not travel read only one page. ");
array_push($quotes,"
          One’s destination is never a place,
                
                   but a new way of seeing things. ");
array_push($quotes,"
          Travel is more than the seeing of sights; 

          it is a change that goes on, deep and permanent,
                
          in the ideas of living. ");
array_push($quotes,"
          要么旅行，要么读书，
          
                   身体和灵魂，必须有一个在路上!");
array_push($quotes,"
          知者乐水，
                   
                   仁者乐山。 ");
array_push($quotes,"
          讀萬卷書，
                   
                   行萬里路 ");
array_push($quotes,"
          我们没有勇气离开，亦没有勇气留下，
                   
                   所以选择旅行,
                   
                            什么是旅行的意义？");
array_push($quotes,"
                   旅行 --
                   
                   自我放逐
                   
                   or  自我救赎？");



echo $quotes[array_rand($quotes)];
}
?>
