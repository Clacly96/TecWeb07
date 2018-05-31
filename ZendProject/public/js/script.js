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


