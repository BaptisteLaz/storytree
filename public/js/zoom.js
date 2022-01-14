let scale = 1;
const el = document.getElementById("panel");
el.onwheel = zoom;
let add=300;
function zoom(event) {

    event.preventDefault();
if (Math.sqrt((scale * scale)) <= 200){
    scale += event.deltaY * -0.1;
}

else if(scale > 200){
    scale=200;
}
else if(scale<-200){
    scale=-200;
}
//
//
if (100<300 + scale<500){
    add = (300 + scale);

}
// else if (scale>=(-200)){
//     scale += event.deltaY * -0.1;
//
// }


    console.log("add: "+add);
    console.log("scale: "+scale);

    // Apply scale transform
    for  (let i = 0; i < el.children.length; i++) {
        el.children[i].style.width = add+'px';
        el.children[i].style.height = add+'px';

    }

}


