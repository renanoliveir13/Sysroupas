document.addEventListener("DOMContentLoaded", function(){
    document.getElementById("nome").addEventListener("change", function(){
        if(document.getElementById("nome").selectedIndex == 5){
            document.getElementById("genero").value = "F"
            document.getElementById("genero").setAttribute("readonly", true);
        }
        else if(document.getElementById("nome").selectedIndex == 6){
            document.getElementById("genero").value = "F"
            document.getElementById("genero").setAttribute("readonly", true);
        }
        else if(document.getElementById("nome").selectedIndex == 7){
            document.getElementById("genero").value = "F"
            document.getElementById("genero").setAttribute("readonly", true);
        }
        else{
            document.getElementById("genero").value = "";
            document.getElementById("genero").removeAttribute("readonly", true);
        }    
    });
});