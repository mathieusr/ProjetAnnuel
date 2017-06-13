/****************** Function qui permet de charger une page dans une div avec la possibilité de transmettre des variables ******/
function loadAjax(page,div,value= null){
    var xhr = new XMLHttpRequest();
    xhr.open('POST',page);
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById(div).innerHTML = xhr.responseText;
        }
    });
    xhr.send(value);
}
/****************** Function qui permet d'afficher ou de cacher un élement html */
function afficherCacher(div,img){
  var test = document.getElementById(div).style.display;
  if(test==='block'){
    document.getElementById(div).style.display='none';
    document.getElementById(img).className='glyphicon glyphicon-triangle-bottom';
  }else{
      document.getElementById(div).style.display='block';
      document.getElementById(img).className='glyphicon glyphicon-triangle-top';
  }
}
/****************** Function pour ouvrir le menu ************/
function openmenu(){
    var classbandeau= document.getElementById('bandeau2').getAttribute('class');
    var popup = document.querySelector('#popupt').style.display
    if(classbandeau === 'bandeau2'){
        document.getElementById('bandeau2').className='bandeau2 open';
        document.getElementById('bandeau1').className='bandeau1 open';
        document.getElementById('popupback').style.display='block';
    }else if(document.getElementById('bandeau2').className=='bandeau2 open' && popup=== ""){
        document.getElementById('bandeau2').className='bandeau2';
        document.getElementById('bandeau1').className='bandeau1';
        document.getElementById('popupback').style.display='none';
    }else if(popup != "" && document.getElementById('bandeau2').className=='bandeau2 open'){
        document.getElementById('bandeau2').className='bandeau2';
        document.getElementById('bandeau1').className='bandeau1';
    }

}
/*********** fonction pour fermer le menu ******************/
function closemenu(){
    var classbandeau= document.getElementById('bandeau2').getAttribute('class');
    var popup = document.querySelector('#popupt').style.display

    if(document.getElementById('bandeau2').className=='bandeau2 open' && popup=== ""){
        document.getElementById('bandeau2').className='bandeau2';
        document.getElementById('bandeau1').className='bandeau1';
        document.getElementById('popupback').style.display='none';
    }else if(popup != "" && document.getElementById('bandeau2').className=='bandeau2 open'){
        document.getElementById('bandeau2').className='bandeau2';
        document.getElementById('bandeau1').className='bandeau1';
    }

}

/************** Ensemble des fonctions pour les champs avec enregistrement automatique **************/
if(document.getElementsByClassName('saveInput')){
    var link = document.getElementsByClassName('saveInput')
    for (var i = 0; i < link.length; i++) {

        link[i].addEventListener('change', saveInput,false);
    }
}

if(document.getElementById('editor')){
    var link = document.getElementById('editor');
    link.addEventListener('blur', saveInput,false);
}

function saveInput(event){
    var value = [];
    var currentvalue ;
    var eventChange = event.currentTarget;

    if(event.currentTarget.value == undefined){
        currentvalue = event.currentTarget.innerHTML;
    }else{
        currentvalue = event.currentTarget.value;
    }
    // On récupère tous les paramètres get de l'URL
    var getParams = window.location.search;
    getParams = getParams.substring(1);
    getParams = getParams.split("&");
    for(var i = 0 ; i < getParams.length ; i++){
        getParams[i] = getParams[i].split('=');
        value[getParams[i][0]] = getParams[i][1];

    }

    // On récupére ensuite l'ensemble des attibuts
    var attr = event.currentTarget.attributes;
    for(var i = 0 ; i < attr.length ; i++){
            value[attr[i].name] = attr[i].value;

    }
    var xhr = new XMLHttpRequest();
    xhr.open('POST',"../conf/saveInput.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            if(xhr.responseText == 'success'){
                eventChange.style.border = "2px solid #2ecc71";
                var dmc_setTimeout = setTimeout(function () {
                    eventChange.style.border = "1px solid #ccc";
                },3000);
            }else if(xhr.responseText == 'error'){
                eventChange.style.border = "2px solid #e74c3c";
                var dmc_setTimeout = setTimeout(function () {
                    eventChange.style.border = "1px solid #ccc";
                },3000);
            }
        }

    });
    xhr.send("id=" + value['articleId'] + "&basename=" + value['base'] + "&columnname=" + value['columnname'] + '&value=' + currentvalue);

}
/***************   Fonction de l'éditeur de texte pour la rédaction d'articles ou autres **************/
function addstyle(nom,argument) {
    document.execCommand(nom, false,argument);
}
if(document.getElementsByClassName('addImage')){
    var link = document.getElementsByClassName('addImage');
    for (var i = 0; i < link.length; i++) {

        link[i].addEventListener('click',addPrincipalImg,false);
    }
}
function addPrincipalImg(event){
    document.getElementById('myPicture').style.display = 'none';
    event.preventDefault();
    alert
    var value = [];
    // On récupére ensuite l'ensemble des attibuts
    var attr = event.currentTarget.attributes;
    for(var i = 0 ; i < attr.length ; i++){
        value[attr[i].name] = attr[i].value;

    }

    var getParams = window.location.search;
    getParams = getParams.substring(1);
    getParams = getParams.split("&");
    for(var i = 0 ; i < getParams.length ; i++){
        getParams[i] = getParams[i].split('=');
        value[getParams[i][0]] = getParams[i][1];

    }

    var xhr = new XMLHttpRequest();
    xhr.open('POST',"../articles/articlesWriteData.php");
    xhr.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    xhr.addEventListener('readystatechange', function() {
        if (xhr.readyState === 4 && xhr.status === 200) {
            document.getElementById('principalImg').innerHTML = xhr.responseText;
        }
    });
    xhr.send('action=addPrincipalImg&idImg=' + value['idimg'] + '&idArticle=' + value['articleId']);
}
if(document.getElementsByClassName('articleImg')){
    var link = document.getElementsByClassName('articleImg');
    for (var i = 0; i < link.length; i++) {

        link[i].addEventListener('click',openModal,false);
    }
}

function openModal(){

}