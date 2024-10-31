//var kbraj = document.getElementsByClassName("tooltipA");
/*kbraj.addEventListener("mouseover", func, false);
kbraj.addEventListener("mouseout", func1, false);

function func()
{
//kbraj.setAttribute("style", "background-color:blue;")
alert("AAAAAA");
}

function func1()
{  
    //kbraj.setAttribute("style", "background-color:green;")
    alert("BBB");
}

*/
$(document).ready(function () {
    var svgplcs = document.getElementById('map-svg-circuit');
    var tooltip_kbrj = svgplcs.getElementById('tooltip-kbrj');
//    alert(tooltip_kbrj)
   // tooltip_kbrj.setAttributeNS(null, "visibility", "hidden");
    
    $("#tooltip-wild").hide();
    $("#tooltip-craft").hide();
    $("#tooltip-aadh").hide();
    $("#tooltip-ramayan").hide();
    $("#tooltip-bkhand").hide();

    //Krishna Braj
    $("#upmap .tooltipA").mouseenter(function (evt) {
        //var CTM = mapPlcs.getScreenCTM();
        var CTM = svgplcs.getScreenCTM();
        //var transformMatrix = [1, 0, 0, 1, 0, 0];
        var x = (evt.clientX - CTM.e + -10) / CTM.a;
        var y = (evt.clientY - CTM.f + -50) / CTM.d;
        //alert(tooltip_kbrj);
        //$("#tooltip-kbrj").show();
        //alert(evtup.clientX)
        const tTip = this.getAttribute("title");
        const mx = this.getAttribute("data-x");
        const my = this.getAttribute("ry");
        //alert(mx);
        $(".TxtHldr").html(tTip);
        tooltip_kbrj.setAttributeNS(null, "visibility", "visible");
        tooltip_kbrj.setAttributeNS(null, "z-index", "99999");
        tooltip_kbrj.setAttributeNS(null, "transform", "translate(" + x + " " + y + ")");

    });
    $("#upmap .tooltipA").mouseleave(function () {
        tooltip_kbrj.setAttributeNS(null, "visibility", "hidden");
    });



    var allStates = $("#map-svg path");
    $(".dList > div").hide()
    $(".dList #dData_32").show();
    allStates.on("click", function (idx) {
        $(".dList > div").hide()
        $(".dList #dData_" + $(this).index()).show();
        allStates.removeAttr("class");
        $(this).attr("class", "selected");
    });

});



var transformMatrix = [1, 0, 0, 1, 0, 0];
var svg = document.getElementById('map-svg');
var svga = document.getElementById('map-svg-circuit');


var tooltip = svg.getElementById('tooltip');
var tooltipText = tooltip.getElementsByTagName('text')[0];
var tooltipRects = tooltip.getElementsByTagName('rect');
var triggers = svg.getElementsByClassName('territory');

var tooltipa = svga.getElementById('tooltipa');
var tooltipTexta = tooltipa.getElementsByTagName('text')[0];
var tooltipRectsa = tooltipa.getElementsByTagName('rect');
var triggersa = svga.getElementsByClassName('territory');



var viewbox = svg.getAttributeNS(null, "viewBox").split(" ");
var centerX = parseFloat(viewbox[2]) / 2;
var centerY = parseFloat(viewbox[3]) / 2;
var matrixGroup = svg.getElementById("matrix-group");


var viewboxa = svga.getAttributeNS(null, "viewBox").split(" ");
var centerXa = parseFloat(viewboxa[2]) / 2;
var centerYa = parseFloat(viewboxa[3]) / 2;
var matrixGroupa = svga.getElementById("matrix-groupa");


for (var i = 0; i < triggers.length; i++) {
    triggers[i].addEventListener('mousemove', showTooltip);
    triggers[i].addEventListener('mouseout', hideTooltip);
}

for (var i = 0; i < triggersa.length; i++) {
    triggersa[i].addEventListener('mousemove', showTooltipa);
    triggersa[i].addEventListener('mouseout', hideTooltipa);
}

function showTooltip(evt) {
    var CTM = svg.getScreenCTM();
    var x = (evt.clientX - CTM.e + 6) / CTM.a;
    var y = (evt.clientY - CTM.f + 20) / CTM.d;
    tooltip.setAttributeNS(null, "transform", "translate(" + x + " " + y + ")");
    tooltip.setAttributeNS(null, "visibility", "visible");

    tooltipText.firstChild.data = evt.target.getAttributeNS(null, "data-tooltip");
    var length = tooltipText.getComputedTextLength();
    for (var i = 0; i < tooltipRects.length; i++) {
        tooltipRects[i].setAttributeNS(null, "width", length + 8);
    }
}

function showTooltipa(evta) {
    var CTM = svga.getScreenCTM();
    //alert(CTM)
    var x = (evta.clientX - CTM.e + 6) / CTM.a;
    var y = (evta.clientY - CTM.f + 20) / CTM.d;
    tooltipa.setAttributeNS(null, "transform", "translate(" + x + " " + y + ")");
    tooltipa.setAttributeNS(null, "visibility", "visible");

    tooltipTexta.firstChild.data = evta.target.getAttributeNS(null, "data-tooltip");
    var lengtha = tooltipTexta.getComputedTextLength();
    for (var i = 0; i < tooltipRectsa.length; i++) {
        tooltipRectsa[i].setAttributeNS(null, "width", lengtha + 8);
    }
}

function hideTooltip(evt) {
    tooltip.setAttributeNS(null, "visibility", "hidden");
}

function hideTooltipa(evta) {
    tooltipa.setAttributeNS(null, "visibility", "hidden");
}







/* */
var svgCat = document.getElementById('map-svg-locations');
var tooltipCat = svgCat.getElementById('tooltip');
var tooltipTextCat = tooltipCat.getElementsByTagName('text')[0];
var tooltipRectsCat = tooltipCat.getElementsByTagName('rect');
var triggersCat = svgCat.getElementsByClassName('territory');


for (var i = 0; i < triggersCat.length; i++) {
    triggersCat[i].addEventListener('mousemove', showTooltipCat);
    triggersCat[i].addEventListener('mouseout', hideTooltipCat);
}

function showTooltipCat(evt) {
    var CTM = svgCat.getScreenCTM();
    var x = (evt.clientX - CTM.e + 6) / CTM.a;
    var y = (evt.clientY - CTM.f + 20) / CTM.d;
    tooltipCat.setAttributeNS(null, "transform", "translate(" + x + " " + y + ")");
    tooltipCat.setAttributeNS(null, "visibility", "visible");

    tooltipTextCat.firstChild.data = evt.target.getAttributeNS(null, "id");
    var length = tooltipTextCat.getComputedTextLength();
    for (var i = 0; i < tooltipRectsCat.length; i++) {
        tooltipRectsCat[i].setAttributeNS(null, "width", length + 8);
    }
}

function hideTooltipCat(evt) {
    tooltipCat.setAttributeNS(null, "visibility", "hidden");
}
