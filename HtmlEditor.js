/*var colorPalette = ['000000', 'FF9966', '6699FF', '99FF66','CC0000', '00CC00', '0000CC', '333333', '0066FF', 'FFFFFF'];

var forePalette = $('.fore-palette');

for (var i = 0; i < colorPalette.length; i++) {
    forePalette.append('<a href="#" data-command="forecolor" data-value="' + '#' + colorPalette[i] + '" style="background-color:' + '#' + colorPalette[i] + ';" class="palette-item"></a>');
}*/

function show() {
    var x = document.getElementById("results");
    if (x.style.display === "none") {
        x.style.display = "block";
    } else {
        x.style.display = "none";
    }
}

function allowSend() {
    var x = document.getElementById("allowsend");


        x.style.display = "block";


}

/*function iFrame(){
    editor.document.designMode='on';

}

function boldtt(){
    editor.document.execCommand('bold',false,null);
}

function italictt(){
    editor.document.execCommand('italic',false,null);
}

function underlinett(){
    editor.document.execCommand('underline',false,null);
}

function fontsizett(){
    var size = prompt("Enter the size", "");
    editor.document.execCommand('fontsize',false,size);
}

function fontcolortt(){
    var color = prompt("Enter the hexa code or name of the color", "");
    editor.document.execCommand('forecolor',false,color);
}

function highlighttt() {
    editor.document.execCommand('backcolor', false, "yellow");
}

function linktt(){
    var link=prompt("Enter the link", "https://");
    editor.document.execCommand('createlink', false, link);
}

function unlinktt(){

    editor.document.execCommand('unlink', false, null);
}*/



