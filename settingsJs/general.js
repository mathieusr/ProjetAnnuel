/****** On trouve ici l'ensemble des add events listener ***********/
addEventOnClass('ajax','click',loadAjax);
addEventOnClass('ajaxForm','submit',loadAjax);
addEventOnClass('saveInput','change',saveInput);
addEventOnClass("butonStyle","click",addstyle);
addEventOnClass("selectStyle","change",addstyle);
addEventOnClass("TextColorButtonPopup","click",openTextColorPopup);

/****** Function qui permet d'executer une requete ajax  ******/
function loadAjax(event,paramf){
    event.preventDefault();
    var popup = document.querySelector('#statusPopup');
    var popupText = document.querySelector('#statusMessage');
    popupText.innerHTML = "Chargement en cours";
    popup.style.display = "block";
    var functionAjax;
    var target = event.currentTarget;
    var param = paramf || null;
    var othervalue;
    var functionValue;
    var page;
    if(param){
        functionAjax = param['function'] || target.dataset.function || null;
        othervalue = param['value'] || null;
        page = param['url'] || target.dataset.url || null;
        functionValue = param['functionValue'] || null;
    }else{
        functionAjax = target.dataset.function || null;
        page = target.dataset.url || null
    }
    var value = AttributesToArray(target) ||'';
    value += '&' + SaveFormData(target)  || null;
    value += '&' + SaveGetData() || null;
    if (window.XMLHttpRequest) {
        var request = new XMLHttpRequest();
    } else {
        var request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    if(page){
        request.open('POST',page);
        request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
        request.addEventListener('readystatechange', function() {
            if (request.readyState === 4 && request.status === 200) {
                popup.style.display = "none";
                if(functionAjax){
                    window[functionAjax](request,target,functionValue);
                }
            }

        });
        request.send(value + '&' + othervalue);
    }
}

function errorMessage(xhr,target,message){
    $notif = $message || 'La dernière action à échouée'
    if(xhr.responseText == 'error'){
        notificationCreate($notif)
    }
}

function checkbox(event){
    var target = event.currentTarget;
    var ifcheck = target.getAttribute('aria-checked');
    if(ifcheck == 'true'){
        target.setAttribute('aria-checked','false');
        target.querySelector('img').src = '../img/icons/check_box.png';
    }else{
        target.setAttribute('aria-checked','true');
        target.querySelector('img').src = '../img/icons/check_box-checked.png';
    }

}

function selectTrueCheckBox(event){
    var target = event.currentTarget;
    var allCheckBox = target.querySelectorAll('.checkbox');
    var trueCheckBox = {"values" : []}
    for(var i=0 ; i< allCheckBox.length ; i++){
        if(allCheckBox[i].getAttribute('aria-checked') == 'true'){
            trueCheckBox.values.push(allCheckBox[i].dataset.value);
        }
    }
    return trueCheckBox;
}

/********* Permet de faire apparaitre une popup de notification pendant un temps définies  *******/
function notificationCreate(text,time){
    var realTime = time || 3000;
    var popup = document.querySelector('#statusPopup');
    var popupText = document.querySelector('#statusMessage');
    if(text !=''){
        popupText.innerHTML = text;
    }
    popup.style.display = "block";
    var dmc_setTimeout = setTimeout(function () {
        popup.style.display = "none";
    },realTime);
}

/****** Function qui vérifie que la requete ajax ne renvoie pas d'error, sinon elle charge une page */
function saveOk(xhr,target){
    if(target.dataset.targetpage && xhr.responseText != "error"){
        notificationCreate("Article sauvegardé");
        document.location.href = target.dataset.targetpage;
    }else{
        notificationCreate("Echec de l'enregistrement des données");
    }
}

/***** Function qui recharge une page **********/
function reloadPage(){
    window.location.reload();
}

/********** Fonction qui récupère toutes les variables d'un formulaire */
function SaveFormData(target){
    var inputs = document.getElementsByTagName('input');
    var textareas = document.getElementsByTagName('textarea');
    var selects = document.getElementsByTagName('select');
    var result = '';
    for(var i=0; i < inputs.length ; i++){
        if(result == ''){
            result += inputs[i].name + '=' + inputs[i].value;
        }else{
            result += '&' + inputs[i].name + '=' + inputs[i].value;
        }
    }
    for(var i=0; i < textareas.length ; i++){
        if(result == ''){
            result += textareas[i].name + '=' + textareas[i].value;
        }else{
            result += '&' + textareas[i].name + '=' + textareas[i].value;
        }
    }
    for(var i=0;i < selects.length ; i++){
        if(result == ''){
            result += selects[i].name + '=' + selects[i].value;
        }else{
            result += '&' + selects[i].name + '=' + selects[i].value;
        }
    }
    return result;
}

/*********** Function qui récupèrer les données postés en GET **************/
function SaveGetData(){
    var value = '';
    var getParams = window.location.search;
    getParams = getParams.substring(1);
    getParams = getParams.split("&");
    for(var i = 0 ; i < getParams.length ; i++){
        getParams[i] = getParams[i].split('=');
        if(value != ''){
            value +=  '&' + getParams[i][0] + '=' + getParams[i][1];
        }else{
            value += getParams[i][0] + '=' + getParams[i][1];
        }
    }
    return value;
}

/************ Function qui permet de récupérer les attributs d'un élements */
function AttributesToArray(target){
    var value;
    var attr = target.attributes;
    var pattern = 'data-';
    for(var i = 0 ; i < attr.length ; i++){
        if(attr[i].name.indexOf(pattern) != -1){
            if(value == ''){
                value += attr[i].name.substring(pattern.length) + '=' + attr[i].value;
            }else{
                value += "&" + attr[i].name.substring(pattern.length) + '=' + attr[i].value;
            }
        }
    }
    return value;
}

/*********** Function qui permet d'ajourter un évenements sur une classe */
function addEventOnClass(classname,action,whatfunction){
    if(document.getElementsByClassName(classname)){
        var link = document.getElementsByClassName(classname);
        for (var i = 0; i < link.length; i++) {
            link[i].addEventListener(action,whatfunction,false);
        }
    }
}

/*********** Function qui permet d'ajourter un évenements sur un id */
function addEventOnId(idname,action,whatfunction){
    if(document.getElementById(idname)){
        var link = document.getElementById(idname);
        link.addEventListener(action,whatfunction,false);
    }
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

// Fonction pour créer une barre de progrès
function createProgressBar(valuenow,minvalue,maxvalue){

    var progressDiv = document.createElement('div')
    progressDiv.className = "progress";
    progressDiv.style['marginBottom'] = "10px";
    progressDiv.style.marginRight = "20px";
    var colorProgressDiv = document.createElement('div');
    colorProgressDiv.className = "progress-bar progress-bar-danger";
    colorProgressDiv.setAttribute('action' , 'progressbar');
    colorProgressDiv.setAttribute('aria-valuenow' , valuenow);
    colorProgressDiv.setAttribute('aria-valuemin' , minvalue);
    colorProgressDiv.setAttribute('aria-valuemax' , maxvalue);
    colorProgressDiv.style.width = "0%";
    progressDiv.appendChild(colorProgressDiv);
    return progressDiv;

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
function iFrameSave(event){
    if(window.frames["editor"]){
        var oFrame = window.frames["editor"].document.getElementById('editor');
        oFrame.addEventListener("blur",saveInput,false);
    }
}

/**************** Function qui permet de sauvegarder automatiquement un input. A améliorer **************************/
function saveInput(event){
    var currentvalue;
    var eventChange = event.currentTarget;
    var popup = document.querySelector('#statusPopup');
    var popupText = document.querySelector('#statusMessage');
    if(event.currentTarget.value == undefined){
        currentvalue = event.currentTarget.innerHTML;
    }else{
        currentvalue = event.currentTarget.value;
    }

    if (window.XMLHttpRequest) {
        var request = new XMLHttpRequest();
    } else {
        var request = new ActiveXObject("Microsoft.XMLHTTP");
    }
    request.open('POST',"../settings/saveData.php");
    request.setRequestHeader("Content-Type", "application/x-www-form-urlencoded");
    request.addEventListener('readystatechange', function() {
        if (request.readyState === 4 && request.status === 200) {
            if(request.responseText == 'success'){
                popupText.innerHTML = "Texte Sauvegardé";
                popup.style.display = "block";
                var dmc_setTimeout = setTimeout(function () {
                    popup.style.display = "none";
                },3000);
            }else if(request.responseText == 'error'){
                popupText.innerHTML = "Echec de la sauvegarde";
                popup.style.display = "block";
                var dmc_setTimeout = setTimeout(function () {
                    popup.style.display = "none";
                },3000);
            }
        }

    });
    request.send("id=" + eventChange.dataset.id + "&basename=" + eventChange.dataset.base + "&columnname=" + eventChange.dataset.columnname + '&value=' + currentvalue);
}

/***************   Fonction d'upload d'image **************/
addEventOnId('uploadForm','submit',function (event) {

    event.preventDefault();
    var popup = document.querySelector('#statusPopup');
    var popupText = document.querySelector('#statusMessage');
    popupText.innerHTML = '';
    popupText.style.display = "block";

    var files = document.querySelector('#file');
    files.disabled = true;
    var totalsize = 0;
    for(var i=0 ; i < files.files.length ; i++){
        var temp = ((files.files[i].size) / Math.pow(1024,2));
        if(totalsize + temp >= 20){
            var p = document.createElement('p');
            p.style.margin = "5px";
            p.style.marginRight = "20px";
            p.innerHTML = "Vos images sont trop lourdes, max 20Mo. Uploader les en plusieurs fois";
            popupText.appendChild(p);
            notificationCreate('',5000);
            files.disabled = false;
            return false;
        }else{
            totalsize += temp;
        }
    }

    // Création du paragraphe
    var p = document.createElement('p');
    p.style.marginBottom = "4px";
    p.innerHTML = "Upload en cours";

    // Ajout à la popup
    popupText.appendChild(p);
    progressDiv = createProgressBar(0,0,100);
    popupText.appendChild(progressDiv);
    popup.style.display = "block";

    // Création de l'objet XMLHttpRequest
    if (window.XMLHttpRequest) {
        var request = new XMLHttpRequest();
    } else {
        var request = new ActiveXObject("Microsoft.XMLHTTP");
    }

    request.open('POST','uploadImgData.php');

    // Calcul du pourcentage de progression
    request.upload.addEventListener('progress',function(event){
        var pourcent = Math.round((event.loaded / event.total) * 100);
        var progressbar = document.querySelector('.progress-bar');
        progressbar.setAttribute('aria-valuenow',pourcent);
        progressbar.style.width = pourcent + "%";
    });

    request.addEventListener('readystatechange',function (event) {
        if (request.readyState === 4 && request.status === 200) {
            // On transforme le text recu en un objet JSON
            var status = JSON.parse(request.responseText);
            // Gestion des erreurs
            if(status['errors'] !=0){
                p.innerHTML = "Upload terminé avec " + status['errors'] + " erreurs";
                var diverror = document.createElement('div');
                diverror.style.marginRight = "15px";
                diverror.style.maxHeight = "200px";
                diverror.style.overflow = "hidden";
                diverror.style.overflowY = "auto";
                diverror.id = "errorDiv";
                for(var statut in status['files']){
                    if(status['files'][statut]['status'] == 'error'){
                        var divname = document.createElement('div');
                        divname.innerHTML = "- " + statut;
                        var ul = document.createElement('ul');
                        var li = document.createElement('li');
                        li.innerHTML = status['files'][statut]['message'];
                        ul.appendChild(li);
                        divname.appendChild(ul);
                        diverror.appendChild(divname);
                    }
                }
                popupText.appendChild(diverror);
                notificationCreate('',7000);
            }else{
                p.innerHTML = "Upload terminé sans erreurs";
                notificationCreate('',5000);
            }
            files.disabled = false;
        }
    });

    // Création de l'objet form data qui permet d'uploader les fichiers avec l'objet XMLHttp request
    var form = new FormData();
    form.append('category',event.currentTarget.category.value);

    // Ajout de l'ensemble des fichiers à la requête
    for(var i=0 ; i < files.files.length ; i++){
        form.append('files[]', files.files[i]);
    }

    request.send(form);
});

/***************   Fonction de l'éditeur de texte pour la rédaction d'articles ou autres **************/
function openTextColorPopup(event){
    var popup = document.getElementById("TextColorPopup");
    if(popup.style.display == "block"){
        popup.style.display = "none";
    }else{
        popup.style.display = "block";
        popup.style.left = event.currentTarget.offsetLeft + "px";
        popup.style.top = "-" + popup.offsetHeight + "px";
    }

    console.log();

}

function addstyle(event) {
    var target = event.currentTarget;
    var argument = null;
    if(target.dataset.argument){
        argument = target.dataset.argument;
    }else if(target.value){
        argument = target.value;
    }
    window.frames["editor"].document.execCommand(target.dataset.action, false,argument);
}

function addImgToArticle(event){
    var target = event.currentTarget;
    var param = { 'function' : 'updatePrincipalImg'};
    if(target.dataset.action === 'textImage'){
        var img = event.currentTarget.parentElement.style.backgroundImage;
        window.frames["editor"].document.execCommand('insertImage', false, img.substring(5,img.length-2));
    }else if(target.dataset.action === 'addPrincipalImg'){
        loadAjax(event,param);
    }
}

function updatePrincipalImg(xhr,target){
    document.getElementById('principalImg').innerHTML = xhr.responseText;
}

function pictureChoose(xhr,target){
    document.getElementById('myModalContent').innerHTML = xhr.responseText;
    document.getElementById('myModalLabel').innerHTML = target.dataset.titreheader;

    addEventOnClass('ajax','submit',loadAjax);
    addEventOnClass('addImage','click',addImgToArticle);
}

function changeDateImg(xhr,event){
    document.getElementById('myModalContent').innerHTML = xhr.responseText;
    addEventOnClass('ajax','submit',loadAjax);
    addEventOnClass('addImage','click',addImgToArticle);
}

/***** Function liée à la boutique ******************/
// Action à réalisé à l'ouverture de la popup
function categoryList(xhr,event){
    document.querySelector('.modal-footer').style.display = 'none';
    document.querySelector('#myModalLabel').innerHTML = "Ajout d'une catégorie";
    document.querySelector('#myModalContent').innerHTML = xhr.responseText;
    addEventOnClass('ajax','click',function(event){
        loadAjax(event);
    });
    addEventOnId('categoryReadForm','submit',submitCategoryForm);

    addEventOnClass('addCat','click',addCategoryPath);
}

// Action à réaliser quand on ajouter un chemin à la catégorie;
function addCategoryPath(event){
    event.preventDefault();
    var select = document.querySelector('#selectCat');
    var selectedValue = select.options[select.selectedIndex].value;
    // Cette requete ajax, permet d'actualiser le select de chemin
    var param = {'value': 'idSelect=' + selectedValue + '&action=refreshSelect', 'function' :  'refreshSelect', 'url' : 'categoryReadData.php'};
    loadAjax(event, param);
    // Cette requete ajax, vérifier et affiche le chemin en cours
    var param = {'value': 'idSelect=' + selectedValue + '&action=getAllpath', 'function' :  'getAllpath', 'url' : 'categoryReadData.php'};
    loadAjax(event, param);
}

// Action à réaliser quand ajoute un chemin à une catégorie
function getAllpath(xhr,target){
    document.querySelector('#catDirectory').innerHTML = xhr.responseText;
    addEventOnClass('checkbox','click',function(event){
        event.preventDefault();
        var param = {'value': 'idSelect=' + event.currentTarget.dataset.parent + '&action=refreshSelect', 'function' :  'refreshSelect', 'url' : 'categoryReadData.php'};
        loadAjax(event, param);
        var param = {'value': 'idSelect=' + event.currentTarget.dataset.parent + '&action=getAllpath', 'function' :  'getAllpath', 'url' : 'categoryReadData.php'};
        loadAjax(event, param);
    });
}

// Cete fonctio envoie le formulaire de catégorie
function submitCategoryForm(event){
    event.preventDefault();
    var value = selectTrueCheckBox(event);
    var param = {'value' : 'path=' + JSON.stringify(value)};
    loadAjax(event,param);
}

// Cette fonction ajoute le nouveau select à la page
function refreshSelect(xhr,target){
    document.querySelector('#addNewPath').innerHTML = xhr.responseText;
    addEventOnClass('addCat','click',addCategoryPath);
}

//Cette fonction permet d'actualiser le tableau
function updateCategory(xhr,target){
    if(target.dataset.method = 'add'){
        document.querySelector('#categoryTable').innerHTML += xhr.responseText;
    }else if(target.dataset.method = 'update'){
     console.log('Test')
    }else{
        notificationCreate('Erreur');
    }
    document.querySelector('.dismissButton').click();
}



function updateSize(xhr,target){
    var param = {'function' : 'addSizeToTable'}
    document.querySelector('.modal-footer').style.display = 'none';
    document.querySelector('#myModalContent').innerHTML = xhr.responseText;
    document.querySelector('#myModalLabel').innerHTML = target.dataset.titreheader;
    document.querySelector('.sizeReadCreate').addEventListener('submit',function(event){
        loadAjax(event,param);
    })
}

function showProductsImage(xhr,target){
    document.querySelector('#myLargeModalContent').innerHTML = xhr.responseText;
    document.querySelector('#myLargeModalLabel').innerHTML = target.dataset.titreheader;
    document.querySelector('.modalLarge-footer').style.display = "none";
    addEventOnClass('ajax','submit',loadAjax);
    addEventOnClass('checkbox','click',checkbox);
    addEventOnClass('photoChooseForm','submit',function(event){
        event.preventDefault();
        var value = selectTrueCheckBox(event);
        var param = {'value' : 'checkbox=' + JSON.stringify(value)};
        loadAjax(event,param)
    });
}

function addSizeToTable(xhr,target){
    if(target.dataset.method == 'update'){
        var values = JSON.parse(xhr.responseText);
        var tr = document.querySelector('#sizeTable tbody #s'+ values['values']['id']);
        var allTd = tr.querySelectorAll('td');
        var count = 0;
        for(var value in values['values']){
            allTd[count].innerHTML = values['values'][value];
            count++;
        }
        updateSizeStatus(xhr,target);
    }else if(target.dataset.method == 'add'){
       document.querySelector('#sizeTable').innerHTML += xhr.responseText;
    }
    addEventOnClass('ajax','click',loadAjax);
    var form = document.querySelector('#productForm');
    if(!form.stock.disabled){
        form.stock.disabled = true;
        form.stock.value = null;
    }
    if(!form.price.disabled){
        form.price.disabled = true;
        form.price.value = null;
    }
    document.querySelector('.closeModal').click();
}

function finishImageUpload(xhr,target){
    if(xhr.responseText != 'error'){
        document.querySelector('#pictureDiv').innerHTML += xhr.responseText;
        addEventOnClass('ajax','click',loadAjax);
    }else{
        notificationCreate("L'ajout de certaines images a échoué");
    }
    document.querySelector('#closeModal').click();

}

function deleteImage(xhr,target){
    if(xhr.responseText != 'error'){
        var parent = target.parentNode;
        document.querySelector('#pictureDiv').removeChild(parent);
    }else{
        notificationCreate('Impossible de supprimer cette image')
    }

}

function updateSizeStatus(xhr,target){
    if(xhr.responseText != 'error'){
        var result = JSON.parse(xhr.responseText);
        var tr = document.querySelector('#sizeTable tbody #s'+ result.values['id']);
        if(result.status['isActive'] == 0){
            tr.className = "danger";
            tr.querySelector("td .updateStatus").innerHTML = "Activer";
        }else if(result.status['isActive'] == 1){
            tr.className = "";
            tr.querySelector("td .updateStatus").innerHTML = "Désactiver";
        }

    }
}
