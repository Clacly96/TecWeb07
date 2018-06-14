var infocategoria=new Array();
$(function(){
    $("#contenuto_centrale>table tr:even").css("background-color","#DDDDDD");
    ridimensionatitoloeventi();    
});

function ridimensionatitoloeventi(){
    $(".listaeventi .titoloev").each(function(){    
    while( $(this).find("p").height() > $(this).height() ) {
        $(this).find("p").css('font-size', (parseInt($(this).find("p").css('font-size')) - 1) + "px" );
    }
        
    });
}    
/*********Submit automatico della form filtro***************/
function submitAjax(actionUrl, formName) {

	function elencaEventi(eventi) {
		$("#contenuto_centrale").html(' ');
		$("#contenuto_centrale").html('<ul class="listaeventi">'+creaListaEventi(eventi)+'</ul>');
                ridimensionatitoloeventi();
	}

	$.ajax({
		type : 'POST',
		url : actionUrl,
		data : $("#" + formName).serialize(),
		dataType : 'json',
		success : elencaEventi
	});
}
// catalogo stile netflix
function catalogoAjaxcaricamento(actionUrl,evperpage){
    function elencaEventiperCat(eventi) {
		for(categoria in eventi){
                    $("#"+categoria+" .lista_categoria").append('<ul class="listaeventi">'+creaListaEventi(eventi[categoria])+'</ul>');
                    infocategoria[categoria]=new Array();
                    infocategoria[categoria]['pagcorrente']=1;
                    infocategoria[categoria]['pagine']=eventi[categoria]['numeroPagine'];
                    
                    $("#"+categoria+" .numero_pagina").text("Pagina "+infocategoria[categoria]['pagcorrente']+"/"+infocategoria[categoria]['pagine']);
                    
                    ridimensionatitoloeventi();
                }
	}

	$.ajax({
		type : 'POST',
		url : actionUrl,
		data : ('evperpage= '+evperpage),
		dataType : 'json',
		success : elencaEventiperCat
	});
}
function catalogoAjaxsuccessiva(actionUrl,evperpage,categoria){
    function elencaEventiperCat(eventi) {
                    $("#"+categoria+" .numero_pagina").text("Pagina "+infocategoria[categoria]['pagcorrente']+"/"+infocategoria[categoria]['pagine']);
                    $("#"+categoria+" .lista_categoria").animate({left:"-100%"},150,"swing",function(){
                        $("#"+categoria+" .lista_categoria").html('<ul class="listaeventi">'+creaListaEventi(eventi)+'</ul>');
                        ridimensionatitoloeventi();
                        $("#"+categoria+" .lista_categoria").css({left:"100%"});
                    });                   
                    
                    $("#"+categoria+" .lista_categoria").animate({left:0},100,"swing");
                    
                }
        
            infocategoria[categoria]['pagcorrente']=(infocategoria[categoria]['pagcorrente']+1<=infocategoria[categoria]['pagine'])?infocategoria[categoria]['pagcorrente']+1:1;
            $.ajax({
                    type : 'POST',
                    url : actionUrl,
                    data : ('evperpage= '+evperpage+'&categoria='+categoria+'&page='+(infocategoria[categoria]['pagcorrente'])),
                    dataType : 'json',
                    success : elencaEventiperCat
            });
    
}
function catalogoAjaxprecedente(actionUrl,evperpage,categoria){
    function elencaEventiperCat(eventi) {
                    $("#"+categoria+" .numero_pagina").text("Pagina "+infocategoria[categoria]['pagcorrente']+"/"+infocategoria[categoria]['pagine']);
                    $("#"+categoria+" .lista_categoria").animate({left:"100%"},150,"swing",function(){
                        $("#"+categoria+" .lista_categoria").html('<ul class="listaeventi">'+creaListaEventi(eventi)+'</ul>');
                        ridimensionatitoloeventi();
                        $("#"+categoria+" .lista_categoria").css({left:"-100%"});
                    });                   
                    
                    $("#"+categoria+" .lista_categoria").animate({left:0},100,"swing");              
                }
       
        infocategoria[categoria]['pagcorrente']=(infocategoria[categoria]['pagcorrente']-1>0)?infocategoria[categoria]['pagcorrente']-1:infocategoria[categoria]['pagine'];    
            $.ajax({
                    type : 'POST',
                    url : actionUrl,
                    data : ('evperpage= '+evperpage+'&categoria='+categoria+'&page='+(infocategoria[categoria]['pagcorrente'])),
                    dataType : 'json',
                    success : elencaEventiperCat
            });
    
}


function creaListaEventi(eventi) {
	if (( typeof (eventi) === 'undefined'))
		return;
            
        if (eventi.length < 1)
             return '<h2>Non ci sono eventi che corrispondono ai parametri di ricerca</h2>'

	var lista='';
	for (chiave in eventi) {
            if(chiave!='numeroPagine'){
		lista += '<li class="ev_li">'
                        + '<a href='+eventi[chiave]['url']+'>'
                        + '<div class="ev_sfondo"> '
                        + '<div class="descev">Descrizione:<br>'+eventi[chiave]['descBreve']+'...</div>'
                        + '<div class="przev"> Prezzo: '+eventi[chiave]['prezzoEvento']+'</div>'
                        + '</div><img src="'+eventi[chiave]['locandinaUrl']+'">';
                    if(eventi[chiave]['scontato']){
                            lista+='<div class="visualizza_sconto">Sconto del '+eventi[chiave]['Sconto']+'%</div>';
                        }
                       lista+='<div class="titoloev"><p>'+eventi[chiave]['Nome']+'</p></div></a></li>';
                   }
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

	var out = '<ul class="errors">';
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
        
        if(document.getElementById("totale_ordine")!==null){
            var prezzounitario=document.getElementById("totale_ordine").innerHTML;

        document.getElementById("Numero_Biglietti").onkeyup = function (){
            var numbiglietti=document.getElementById("Numero_Biglietti").value;
            totale=numbiglietti*prezzounitario;
            document.getElementById("totale_ordine").innerHTML=totale;
        }
        
        
    }

};


