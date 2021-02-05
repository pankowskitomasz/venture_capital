var dataContent=[];

$(".nav-menu-icon").click(function(){
    $(".nav-menu").toggleClass("nav-menu--open");
});

$("#index-s6-owl").owlCarousel({
    loop:true,
    responsive:{
        0:{items:1},
        600:{items:2},
        840:{items:3}
    }
});

function processData(dataA){
    var hnd = document.getElementById("items-container");
    var output="";
    if(Array.isArray(dataA)){
        for(var i=0;i<dataA.length;i++){
            output += "<div class=\"mdc-card mdc-card--outlined p-2 mb-2\">";
            output += "<div class=\"mb-1\"><h4 class=\"m-0\">";
            output += dataA[i].title;
            output += "</h4><small>";
            output += dataA[i].category;
            output += "</small></div><div class=\"border-t border-gray\"><p>";
            output += dataA[i].description;
            output += "</p></div></div>";
        }
    }
    hnd.innerHTML = output;
}

function filterData(filterA,dataA){
    var res = [];
    if(Array.isArray(dataA) && filterA!=="All"){
        res = dataA.filter(function(item){return item.category==filterA});
    }
    else{
        res = dataA;
    }
    return res;
}

function updateList(){
    var fhnd = document.getElementsByName("filterList")[0];
    var res = filterData(fhnd.options[fhnd.selectedIndex].text,dataContent);
    processData(res);
}

function getPortfolioData(){
    var xmlhttp;
    if(window.XMLHttpRequest){
        xmlhttp = new XMLHttpRequest();
    }
    else{
        xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
    }
    xmlhttp.onreadystatechange = function(){
        if(this.readyState==4 && this.status==200){
            dataContent=JSON.parse(this.responseText);
            var fhnd = document.getElementsByName("filterList")[0];
            fhnd.addEventListener("change",updateList);
            updateList();
        }    
    }
    xmlhttp.open("GET","portfoliodata.php",true);        
    xmlhttp.setRequestHeader("Content-Type", "text/plain");
    xmlhttp.send();
}

if(window.location.href.indexOf("portfolio")>=0){
    getPortfolioData();
}