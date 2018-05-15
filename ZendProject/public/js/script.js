            window.onresize =function(){
                var altezza = window.innerHeight;
                var posizione = altezza - 100;
                document.getElementById("contenuto_laterale").style.height = posizione+"px";             
             }; 
            window.onload = function (){            
                var altezza = window.innerHeight;
                var posizione = altezza - 100;
                document.getElementById("contenuto_laterale").style.height = posizione+"px";            
     
                document.getElementById("tastomenu").onclick = function (){
                    if (document.getElementById("menu").style.display === "block")
                        document.getElementById("menu").style.display = "none";
                    else
                        document.getElementById("menu").style.display = "block";
                };
        };


