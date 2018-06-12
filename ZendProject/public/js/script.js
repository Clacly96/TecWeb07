$(function(){
    $("#contenuto_centrale>table tr:even").css("background-color","#DDDDDD");
});

/*********Submit automatico della form filtro***************/
function submitAjax(actionUrl, formName) {

	function elencaEventi(eventi) {
		$("#listaeventi").html(' ');
		$("#listaeventi").html(creaListaEventi(eventi));
	}

	$.ajax({
		type : 'POST',
		url : actionUrl,
		data : $("#" + formName).serialize(),
		dataType : 'json',
		success : elencaEventi
	});
}

function creaListaEventi(eventi) {
	if (( typeof (eventi) === 'undefined'))
		return;
            
        if (eventi.length < 1)
             return '<h2>Non ci sono eventi che corrispondono ai parametri di ricerca</h2>'

	var lista='';
	for (chiave in eventi) {
		lista += '<li class="ev_li">'
                        + '<a href='+eventi[chiave]['url']+'>'
                        + '<div class="ev_sfondo"> '
                        + '<div class="descev">Descrizione:<br>'+eventi[chiave]['descBreve']+'...</div>'
                        + '<div class="przev"> Prezzo: '+eventi[chiave]['prezzoEvento']+'</div>'
                        + '</div><img src="'+eventi[chiave]['locandinaUrl']+'">';
                    if(eventi[chiave]['scontato']){
                            lista+='<div class="visualizza_sconto">Sconto del '+eventi[chiave]['Sconto']+'%</div>';
                        }
                       lista+='<div class="titoloev">'+eventi[chiave]['Nome']+'</div></a></li>';
            }
	return lista;
}

                           

/************Validazione automatica form*********************/
function doValidation(id, actionUrl, formName) {

	function showErrors(resp) {
		$("#" + id).parent().parent().find('.td_errors').html(' ');
		$("#" + id).parent().parent().find('.td_errors').html(getErrorHtml(resp[id]));
	}

	$.ajax({
		type : 'POST',
		url : actionUrl,
		data : $("#" + formName).serialize(),
		dataType : 'json',
		success : showErrors
	});
}

function getErrorHtml(formErrors) {
	if (( typeof (formErrors) === 'undefined') || (formErrors.length < 1))
		return;

	var out = '<ul>';
	for (errorKey in formErrors) {
		out += '<li>' + formErrors[errorKey] + '</li>';
	}
	out += '</ul>';
	return out;
}




            
if(document.getElementById("contenuto_laterale")!==null){
    window.onresize =function(){
        var altezza = window.innerHeight;
        var posizione = altezza - 100;
        document.getElementById("contenuto_laterale").style.height = posizione+"px";             
     };
 }
 var totale=0;
    window.onload = function (){            
        var altezza = window.innerHeight;
        var posizione = altezza - 100;
        if(document.getElementById("contenuto_laterale")!==null)
            document.getElementById("contenuto_laterale").style.height = posizione+"px";            

        document.getElementById("tastomenu").onclick = function (){
            if (document.getElementById("menu").style.display === "block")
                document.getElementById("menu").style.display = "none";
            else
                document.getElementById("menu").style.display = "block";
        };
        if(document.getElementById("totale_ordine")!==null){
            var prezzounitario=document.getElementById("totale_ordine").innerHTML;

        document.getElementById("Numero_Biglietti").onkeyup = function (){
            var numbiglietti=document.getElementById("Numero_Biglietti").value;
            totale=numbiglietti*prezzounitario;
            document.getElementById("totale_ordine").innerHTML=totale;
        }
    }

};


