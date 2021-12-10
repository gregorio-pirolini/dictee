jQuery.noConflict(); //$ freigegeben
jQuery(document).ready(function($){
var wordAsked;

var aLevels=['A','B','C','D'];
var levels;// aLevels[1]='A'
var $level; //ABCD
var $user;//data['username']; bzw gregorio
var $id; //6
 
var randomOrder; // 1 2 3
var actualQuestion;
var round=0;
var caps=false; 
//create ul li
var valueForWord=0;
var art='spell';
var marche;
var aide;
var regexLetterAllowed=new RegExp(/^[\'|[a-zA-Z]|à|â|ç|ë|é|è|ê|î|ï|ô|œ|û|ù|ü|-|]$/);
 var aCorrectionToSpeak;
var tried=0; //number of tries min 0 max 2
var aWordsItsWrong=[];
var aWordsItsGood=[];
var actualText;
var pts; //point to add
var aAskedWords=[];//arr of words asked
var 番号;//th of words asked
var points;// starting points
var maxRound=14; //0 is 1 too max 14
var audio;  
var $vol=0;
var i=0;//first letter
var listenToMe=true; // user not allowed to type
var aideWasClicked=false // user clicked aide


function checkInRegex(val){ //one letter and in regex   
console.log('checkInRegex('+val+')');
if(val.length>1){
 console.log('no')
return 1;
}else if(!regexLetterAllowed.test(val)){
 console.log('no')
return 1;
}else{ 
    console.log('yes')
return 0;
}
}

$('#spellwordsBox input').prop("maxLength", 12);


console.log('aKeys');
createToy(aKeys); //variables.js

getUserInfo();
var handle = $( "#custom-handle" );
function getUserInfo(){
    console.log('getUserInfo');
  $.getJSON('php/getUserInfo.php',  function(data, status){
      $level=data['level'];
      $user=data['username'];
      $id=data['id'];
      $vol=data['audio']/100;
//      alert('1: '+$vol);
       console.log('userId: '+$id); 
    $('#levelUser').text(data['level']);
    $('#nameUser').text(data['username']);
   calculateLevels($level);
   $( "#slider" ).slider({
      create: function() {
     handle.text( $( this ).slider( "value" ) );
var $vol100=Math.floor($vol*100);
//alert('2: '+$vol100);
        handle.text($vol100);
        $('#custom-handle').css('left',$vol100+'%');
      },
      slide: function( event, ui ) {
        handle.text( ui.value );
//        console.log('moving '+ui.value/100);
        var $newVol=ui.value/100;
        $vol=$newVol;
        
      },
      stop: function( event, ui ) {
        handle.text( ui.value );
         console.log('stoped ---------------------');
        console.log('stoped '+ui.value);
         console.log('stoped ---------------------');
         $.post("php/update_audio.php", "audio="+ui.value+"&id="+$id , function(result,status){
            console.log("php/update_audio.php"+ result+', '+status); 
         });
         
}
    });
   playSound('MELODY1','depart');
  }
           );
       }

function calculateLevels(x){//$level A B C
     $.each( aLevels, function( key, value ){
        if(x===value){levels=key;
//         startGame();
         }
       
    });
   
}

function createToy(arr){
console.log(aKeys);
   console.log('createToy 1'); 
    var myKeyBoard='';
    myKeyBoard+='<div id="yellow"><div id="red"><ul class="keyboard">';
  $.each( arr, function( key, value ){
      var befehl1='';
       var befehl2='';
      if (value[3]!==''){befehl1= value[3];}
      if (value[4]!==''){befehl2= value[4];}
       myKeyBoard+='<li><ul><li>'+befehl2+'</li><li  style="background-color:'+value[2]+'"><table width=100% height=100%><tr><td valign=middle class="'+value[5]+'" data-keyCode="'+value[1]+'">'+value[0]+'</td></tr></table></li><li>'+befehl1+'</li></ul></li>'
       ;
  });
     
    myKeyBoard+='</ul></div><br><img src="pix/logo.jpg" id="logo"></div>';
  $('#clickMe').append(myKeyBoard);
  

}
 
//events
//letters

 $('body').on('click', '.letter', function() {
if(listenToMe==true){return;}
//    alert('click.letter '+$(this).text());
var letter=$(this).text();
if(caps==true){
    letter=letter.toUpperCase();
}
actualText=$("input").val();
if(checkInRegex(letter)<1){ 
        if(actualText.length<12){
            speakletter(letter);
        $("#spellwordsBox input").val(actualText+letter);
        }else{
        alert('12 letters max');
        }
}
    doLowercase();
    
});


 
$('body').on('click', '.befehl', function() {
var data_keycode;
data_keycode=($(this).attr('data-keycode'));
console.log('marche='+marche+ '&& data_keycode=='+data_keycode  );
if(data_keycode==='ARRÊT'){
    playSound('MELODY4','logOut');
}
else if(art=='?'){
    console.log('?')
     console.log('no programmed yet')
     
}else if(art=='spell'){
    if(data_keycode==='DÉPART'){
       i=100;
       audio.pause();
       playSound('MELODY2','startGame');
       $('#points').html('0 Pts');
       $('#wordNumber').html(0);
    }else if((marche==true)&&(data_keycode=='MARCHE')){
          
         doGame('spell',aAskedWords,番号);
        marche=false;
        return;
    }else if(listenToMe==true){
            return;
    }else{
    actualText=$("input").val();
        if(data_keycode==16){//uppercase
                               doUppercase();
                           return; }
        else if(data_keycode==8){//delete one
        console.log('backspace')
        $("input").val(actualText.substr(0,actualText.length-1));
        }else if(data_keycode=='REJOUE'){
        $("input").val('');  //delete all
        }else if(data_keycode==13){
        aide=false;
        checkWord(actualText);
        }else if(data_keycode=='RÉPÈTE'){
        listenToMe=true;
        i=0;
        speakOrOrder(actualQuestion,0,'do nothing', 'click');
        }else if(data_keycode=='MYSTÈRE'){
        alert('not programmed yet');
        return;
    //doGame('?',aMotsA,0);
        }
    }
}
 
doLowercase();
});


 $('body').on('mousedown', '.befehl', function() {
    
var data_keycode;
data_keycode=($(this).attr('data-keycode')); //letter clicked or befehl
console.log('..............mousedown aide='+aide);
if(listenToMe===true){return;}
else if(aide===true){
    
console.log('..............mousedown aide='+aide);
actualText=$("input").val();
if(data_keycode==='AIDE'){
    aideWasClicked=true;
showWord();
}
}
});

 $('body').on('mouseup', '.befehl', function() {
     var data_keycode;
data_keycode=($(this).attr('data-keycode'));
console.log('..............mousedown aide='+aide);
if(listenToMe==true){return;}
else if(aide==true){
console.log('..............mouseup aide='+aide);

   unshowWord();
 
}});  
 
//dont let click the input
$('body').on('focus', '#spellwordsBox input', function() {
$('#spellwordsBox input').blur();
});



$("body").keypress(function(e){
    console.log('keypress')
   
    
if(listenToMe==true){
    console.log('listenToMe')
    var x = e.which || e.keyCode;
    if(x==8){
    console.log('backspace');
     e.preventDefault();
     console.log('wont go back');
     return;}
 }
    var x = e.which || e.keyCode;
//  alert(" input.keypress "+e.key+"The Unicode value is: " + x);
if(x==13){//ente
var test= $("input").val();  //delete all
 aide=false;// show word is disabled
checkWord(test);
return;
}else if(x==8){
console.log('backspace');
 e.preventDefault();
var actualText=$("input").val();
$("input").val(actualText.substr(0,actualText.length-1));
return;
}else{
var letter=e.key;
console.log(letter);
if(checkInRegex(letter)<1){   
var actualText=$("input").val();
    if(actualText.length<12){
         speakletter(letter);
    $("input").val(actualText+letter);
    }else{
    alert('12 letters max');
    }
 }
  }
 doLowercase();   
});

var onHold=false;//caps
$(document).keydown(function (e) {
    if(listenToMe==true){return;}
    if (e.keyCode == 16) {  
        if(onHold==false){
     doUppercase(); 
     onHold=true;
      }else{
          return;
      }
    }
});

$(document).keyup(function (e) {
    if(listenToMe==true){return;}
    if (e.keyCode == 16) {  
 doLowercase();
 onHold=false;
    }
});







function CHR(ord)
{//return letter from  charcode
return String.fromCharCode(ord);
}

function ORD(chr)
{
return chr.charCodeAt(0);
}

 
 
function startGame( ){
     console.log(aAskedWords.length);
     $('ul.keyboard li:nth-child(7) ul li:nth-child(2)').removeClass("blink");
    $('ul.keyboard li:nth-child(2) ul li:nth-child(2)').removeClass("blink");
    points=0;
    round=0;
//    alert(round);
    $('#points').html(points +' Pts');
    aAskedWords=[];
    
    //pick 15 words in arr
    findRandomeWords(aLevels[levels]);
    
 
}
  function shuffleArray(array) {
   
   return array;
}
function findRandomeWords(arr){// arr=A,B,C,D
 console.log('findRandomeWords');

 


//  alert("level="+$level+"&user="+$user);
// pick 15 words from A
$.post("php/load_15_words.php","user="+$user+"&level="+$level, function(result,status){
        console.log("Data: " + result + "\nStatus: " + status);
        if(result!==0){
        var RESULT=JSON.parse(result );
        $.each(RESULT, function(idx, obj) {
           var smallArray=[obj.word, obj.folder, obj.id, obj.words_number]; 
            aAskedWords.push(smallArray);
               
        });
         console.log('aAskedWords');
        console.log(aAskedWords);
        
   shuffleArray(aAskedWords);
番号=-1;
 doGame('spell',aAskedWords,番号);     
}
    }); 
   
 
}
  
 
function doGame(game,arr){//'spell',aAskedWords,nb ->jeux array nb
 
if(art=='spell'){
       console.log('aAskedWords');
       console.log(aAskedWords);
     $('ul.keyboard li:nth-child(7) ul li:nth-child(2)').removeClass("blink");
  if(番号<maxRound){//limit to 15 words
     
        
      
  
    番号++;   
    
    
    

$("input").val('');
         $('input').css('font-family','MS Shell Dlg');//
console.log('................doGame,'+ arr +','+番号);  
// for each word 
// say befehl + word
art=game; //spell or mystere
aide=false;// disable button aide();
 console.log('aide='+aide);
marche=false;// disable button marche();
listenToMe=true; //disable typing
tried=0;//number of tries min 0 max 2
i=0;

 
console.log('arr:'+arr);
 randomOrder=Math.floor(Math.random()*(aEpelleCourt.length-1)+0);

$("input").val('');
//alert(round );
//alert(round%2);
 wordAsked=aAskedWords[番号][0];
// alert(番号+ ': will ask '+ aAskedWords[番号][0])
if(round%2===0){
actualQuestion=[aEpelleCourt[randomOrder ],aAskedWords[番号]];}
else{actualQuestion=[aEpelleLong[randomOrder ],aAskedWords[番号]];}
speakOrOrder(actualQuestion,0,'do nothing','doGame');
round++;
$('#wordNumber').html(round);
// alert(round);
  }else{
       playSound('MELODY4','sendPoints2');
     
    
   
     
  }


  
  }else{
      alert('not programmed');
      $("input").val('');
      console.log('play mystere');
    
}
}

var myTitle;
var myMessage;
function sendPoints(from){
   
console.log('sendpoint '+from);
//get user points

$.post("php/update_points.php", "points="+points+"&id="+$id  , function(result,status){
if(isNaN(result)){
  alert('ERROR  isNaN(result)');
  }else{
      console.log('sendPoints all good');
  myTitle='Points';
  myMessage='<p>Tu as: <b>'+ points +'</b> points<\p><p>Tu as: <b>'+ result +'</b> points en tout<\p>';
 
  DIALOG(myTitle,myMessage);
  }
});


//get words points
//      $.each( aRandomWord, function( key, value ){
$.each(aAskedWords,function(id,val){
console.log(val[0]+' '+val[1]+' '+val[2]+' '+val[3]);
        $.post("php/update_word_value.php", "val="+val[3]+"&id="+val[2]+"&user="+$user , function(result,status){
        
            console.log(id+': '+result);
            if(id>13){
               updateLevel();  
            }
       
});
});



}

function updateLevelNb(){
   levels++;
   if(levels>aLevels.length-1){levels=aLevels.length-1;}
   $level=aLevels[levels];
}

function updateLevel(){
    //make list of all words in level
    //if level >85 good move to next one
    //good means has been asked last asked> 0 and word number < 2 
    
    $.post('php/update_level.php','userName='+$user+'&levelLetter='+$level, function(result,status){
            
            console.log(result);
            myMessage+='<p>'+result+'</p>';
             if(result.search('Félicitations: tu passes au niveau suivant!')>-1){
                updateLevelNb();
                 
                 $('#levelUser').text(aLevels[levels]);
                  $.post("php/update_levelUser.php", "level="+aLevels[levels]+"&userid="+$id, function(result,status){
                      
                      
                  });
                  
             }
             $('#dialog-message').html(myMessage);
             
        
        //check if som words are wrong
        var wrongWords=0;
             $.each(aAskedWords,function(id,val){
                if(val[3]>2){
           wrongWords++;
         } 
         
         
         
         });
          if(wrongWords>0){youMustLearn();}else{$('.ui-button.ui-corner-all.ui-widget').css('visibility','visible');};
         
        
             }
             
           
     
    );
   
};
//console.log(val[0]+' '+val[1]+' '+val[2]+' '+val[3]); ventre mots/A 32 3
function youMustLearn(){
    var $youMustLearn='<p>Tu dois apprendre: <b>';
 $.each(aAskedWords,function(id,val){
     if(val[3]>2){
         $youMustLearn+=val[0]+',';
     }
 });
 $youMustLearn=$youMustLearn.substring(0, $youMustLearn.length-1);
 $youMustLearn+='</b>.</p>';
 $('#dialog-message').append($youMustLearn);
  $('.ui-button.ui-corner-all.ui-widget').css('visibility','visible');  
}


function update_word_value(arr){
//    if(番号>-1){
// valueForWord+=Number(aAskedWords[番号][3]);
// if(valueForWord<0){valueForWord=0;}
//    
//    $.post("php/update_word_value.php", "val="+valueForWord+"&id="+aAskedWords[番号][2]   , function(result,status){
//             if(isNaN(result)){
//            
//             }else{
//           
//        
//             }
//        }); 
//        }
};




function showWord(){
    $("input").val(wordAsked);
}

function unshowWord( ){
    $("input").val(actualText);
}


function checkWord(test){
    aide=false; //disable button help
//alert('checkWord(test) wordAsked: '+wordAsked);

//alert(round);
console.log('aAskedWords aide='+aide);
if(test==wordAsked){//correct answer

    if((tried<1)&&(aideWasClicked==false)){ //first time no help
        pts=100;
    var actualWordPoints=aAskedWords[round-1][3]; //check  the word points
    console.log('actualWordPoints:'+ actualWordPoints);
    var newWordPoints=actualWordPoints-1; //remove one point from the word points
      console.log('newWordPoints:'+ newWordPoints);
      if(newWordPoints<0){
          newWordPoints=0;
      }
      aAskedWords[round-1][3]=newWordPoints; //set the word points
       console.log('newWordPoints:'+ newWordPoints);
       }else{//not first time or was helped
        pts=50;
        valueForWord=3;
        aAskedWords[round-1][3]=valueForWord;
       
   }
       points+=pts; 
       $('#points').html(points+' Pts');
       var randomBien=Math.floor(Math.random()*(aBien.length-1)+0);
       aWordsItsGood=[aBien[randomBien]];
       i=0;//thefirst word spoken
       speakOrOrder(aWordsItsGood,0,'do game','checkWord');
       //send to db word was ok
         
}else{  //word not spelled write
       valueForWord=4;
        aAskedWords[round-1][3]=valueForWord;
         
        var randomFaux=Math.floor(Math.random()*(aFaux.length-1)+0);
        if(tried<1){
             
             var randomRecommence=Math.floor(Math.random()*(aRecommence.length-1)+0);
             var randomaEpelleCourt=Math.floor(Math.random()*(aEpelleCourt.length-1)+0);
             aWordsItsWrong=[ aFaux[randomFaux] , 
             aRecommence[randomRecommence] , 
             aEpelleCourt[randomaEpelleCourt],
             aAskedWords[番号]];
             $("input").val(''); 
             i=0;
             speakOrOrder(aWordsItsWrong,0,'do nothing','checkWord');
             tried=1;
       //send to db word was wrong
       
   }else{
      
       var randomCorrection=Math.floor(Math.random()*(aCorrection.length-1)+0);
       aCorrectionToSpeak=[ [aCorrection[randomCorrection][0][0],'ordres/correction'], [aCorrection[randomCorrection][0][1],'ordres/correction']] ; 
        aWordsItsWrong=[ aFaux[randomFaux], aCorrectionToSpeak[0], aAskedWords[番号],aCorrectionToSpeak[1]];
     
       var aRandomWord=aAskedWords[番号][0].toString().split('');
         $.each( aRandomWord, function( key, value ){
         aWordsItsWrong.push([ value.charCodeAt(0) ,'lettres/']);
    });
        aWordsItsWrong.push(aAskedWords[番号]);
        $("input").val(''); 
        i=0;
       speakOrOrder(aWordsItsWrong,0,'setMarche','checkWord');
      //move to next word
       
   }
       
};   
//send word to db  
aideWasClicked=false;
 
}


  

function  playSound(melody,next){ 
    audio = new Audio('audio/sound/'+melody+'.mp3');
    var $volQuiet=$vol/2;
    audio.volume=$volQuiet; 
    audio.loop = false;
    audio.play(); 
    audio.addEventListener("ended", function(){
        if(next=='depart'){
       $('ul.keyboard li:nth-child(2) ul li:nth-child(2)').addClass("blink");
        }else if(next=='startGame'){
            startGame(); 
        }else if(next=='logOut'){
           logout();
           
           
       }else if(next=='sendPoints1'){
        
        sendPoints('playSOund');
    }else if(next=='sendPoints2'){
       sendPoints('do game'); 
        
    }
});
}

function logout(){
     $.post("logout.php", function(data, status){
       location.reload();
    });
}

function  speakletter(letter){ 
    audio = new Audio('audio/lettres/'+letter.charCodeAt(0)+'.mp3');
    audio.volume=$vol; 
    audio.loop = false;
    audio.play();    
}

//speak(aCorrection,'correction',i);

function speakOrOrder(arr,nb,next,kara){
    console.log('speakOrOrder'+' from '+kara);
     aide=false;
    console.log(arr);
    console.log('speakOrOrder'+','+nb+','+next);
    console.log('speakOrOrder aide='+aide);
    if (nb<arr.length){
        console.log('...speaking...')
        playMe(arr,nb,next);
        listenToMe=true;
        actualText='';
       
    }else{
        if(next=='do game'){
           console.log('...do game...'); 
            actualText='';
            doGame('spell',aAskedWords,番号);
            aide=false;
            console.log('aide='+aide);
        }else if (next=='do nothing'){
            console.log('...waiting...')
            actualText='';
            listenToMe=false;
            aide=true;
            console.log('aide='+aide);
            return;
        }else if (next=='setMarche'){   
            console.log('...setMarche...');
            actualText='';
            listenToMe=true;
            marche=true;
            aide=false;
                if(番号<maxRound){
                
                console.log('aide='+aide);
                $('ul.keyboard li:nth-child(7) ul li:nth-child(2)').addClass("blink");
                }else{
                    
                    playSound('MELODY4','sendPoints1');
                    
                    
                }
       }
  }  

}

function  speak(arr,nb,doNext){ 
    console.log(nb+'speak arr:'+arr);
playMe(arr,nb);
} 


function  playMe(arr,nb,next){
aide=false;


        console.log(nb + 'playMe arr:'+arr);
//        console.log(番号+' '+'audio/'+arr[番号][1]+'/'+CHR(arr[番号][0])+'.mp3');
        console.log('aide='+aide);
if(arr[nb][0]!==''){
     if(arr[nb][1]=='lettres/'){
         $('input').val($('input').val()+CHR(arr[nb][0]))}
    audio = new Audio('audio/'+arr[nb][1]+'/'+arr[nb][0]+'.mp3');
    audio.volume=$vol;
    audio.play(); 
    audio.addEventListener("ended", function(){
    audio.currentTime = 0;
    i++;
    speakOrOrder(arr,i,next, 'playMe');
 
}); } else{ i++;
    speakOrOrder(arr,i,next, 'playMe');}
   }




function doUppercase(){  
if(caps==false){
$('.letter').css('text-transform','uppercase')
            .css('font-size','50px'); 
caps=true;
}else{
doLowercase();
}

}

function doLowercase(){
$('.letter').css('text-transform','lowercase')
            .css('font-size','55px');   
caps=false;
}

  
    

  function DIALOG(title,text){
      $('button.ui-button').css('visibility','hidden'); 
      $('#dialog-message').html(text);
$( "#dialog-message" ).dialog({
      modal: true,
      title: title,
      
      buttons: {
        Ok: function() {
          $( this ).dialog( "close" );
           $('ul.keyboard li:nth-child(2) ul li:nth-child(2)').addClass("blink"); 
        }
      }
    });
    }    
    
//   $('body').on('click', '#spellwordsBox', function() { DIALOG();});
    $('button.ui-button').css('visibility','hidden'); 
});

