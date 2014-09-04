/*
 RESIZE
 */
$(function(){
    window.onresize = resize;
    //window.onload = load;
});

function load() {
    var ctx = document.getElementById("canvas").getContext("2d");
    window.myLine = new Chart(ctx).Line(lineChartData, {
        responsive: true,
        showScale: false
    });
}

function resize() {
    // RIGHT MENU
    document.getElementById("right-menu").style.display = 'none';
    document.getElementById('right-menu-ref').style.opacity = "";
    document.getElementById('content').style.paddingRight = "50px";
    document.getElementById('right-menu-ref').style.width = "140px";
    document.getElementById('right-menu-ref-a').style.width = "140px";

    // RIGHT MENU CENTER
    document.getElementById("right-menu-center").style.display = 'none';
    document.getElementById('wrapper').style.backgroundColor = "";
    document.getElementById('wrapper').style.opacity = "";

    //GRAPH
    //var width = document.getElementById("canvas").parent().width();
    //document.getElementById("canvas").attr("width", width);
    //new Chart(ctx).Line(data,options);
}

/*
 GLOBAL FUNCTION
 */
function toggleVisibility(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none') {
        $('#' + id).slideToggle('');
        e.style.display = 'block';
    } else {
        e.style.display = 'none';
    }
}

/*
SEARCH MENU
 */
function searchBarVisibility(id) {
    toggleVisibility(id);
    toggleSearchBar(id);
}

function toggleSearchBar(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none') {
        document.getElementById('top-menu-search').style.opacity = "";
        document.getElementById('right-menu').style.paddingTop = "95px";
        document.getElementById('content').style.paddingTop = "100px";
    } else {
        document.getElementById('top-menu-search').style.opacity = "0.8";
        document.getElementById('right-menu').style.paddingTop = "140px";
        document.getElementById('content').style.paddingTop = "140px";
    }
}

/*
RIGHT MENU / RIGHT MENU CENTER
 */
function rightMenuVisibility(id) {
    var w = window.innerWidth;
    if (w > 1900) {
        toggleVisibility(id);
        toggleRightMenu(id);
    } else {
        toggleVisibility('wrapper');
        toggleVisibility('right-menu-center');
        toggleRightMenuCenter('right-menu-center');
    }
    //var width = document.getElementById("canvas").parent().width();
    //document.getElementById("canvas").attr("width", width);
}

function toggleRightMenu(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none') {
        document.getElementById('right-menu-ref').style.opacity = "";
        document.getElementById('content').style.paddingRight = "50px";
        document.getElementById('right-menu-ref').style.width = "140px";
        document.getElementById('right-menu-ref-a').style.width = "140px";
    } else {
        document.getElementById('right-menu-ref').style.opacity = "0.8";
        document.getElementById('content').style.paddingRight = "500px";
        document.getElementById('right-menu-ref').style.width = "430px";
        document.getElementById('right-menu-ref-a').style.width = "430px";
    }
}

function toggleRightMenuCenter(id) {
    var e = document.getElementById(id);
    if(e.style.display == 'none') {
        document.getElementById('right-menu-ref').style.opacity = "";
        document.getElementById('wrapper').style.backgroundColor = "";
        document.getElementById('wrapper').style.opacity = "";
    } else {
        document.getElementById('right-menu-ref').style.opacity = "0.8";
        document.getElementById('wrapper').style.opacity = "0.8";
        document.getElementById('wrapper').style.backgroundColor = "black";
    }
}

/*
GRAPH
 */
/*var randomScalingFactor = function(){ return Math.round(Math.random()*100)};
var lineChartData = {
    labels : ["January","February","March","April","May","June","July"],
    datasets : [
        {
            label: "My First dataset",
            fillColor : "rgba(220,220,220,0.2)",
            strokeColor : "rgba(220,220,220,1)",
            pointColor : "rgba(220,220,220,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(220,220,220,1)",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        },
        {
            label: "My Second dataset",
            fillColor : "rgba(151,187,205,0.2)",
            strokeColor : "rgba(151,187,205,1)",
            pointColor : "rgba(151,187,205,1)",
            pointStrokeColor : "#fff",
            pointHighlightFill : "#fff",
            pointHighlightStroke : "rgba(151,187,205,1)",
            data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
        }
    ]
}*/
