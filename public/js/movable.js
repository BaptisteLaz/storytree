const moveMe = document.querySelectorAll('.cardboard');
message = document.getElementById('message');

let diffY,
    diffX,
    elmHeight,
    elmWidth,
    containerHeight,
    containerWidth,
    isMouseDown = false;

function mouseDown(e) {
    isMouseDown = true;

    // get initial mousedown coordinated
    const mouseY = e.clientY;
    const mouseX = e.clientX;

    // get element top and left positions
    // window.alert(e.currentTarget.idBox);
    for (let i = 0; i < moveMe.length; i++) {
        if (i == e.currentTarget.idBox) {
            const elm = moveMe[e.currentTarget.idBox];
            console.log(elm);
            const elmY = elm.offsetTop;
            const elmX = elm.offsetLeft;
            console.log("elmY: " + elmY);
            console.log("elmX: " + elmX);
            // get elm dimensions
            elmWidth = elm.offsetWidth;
            elmHeight = elm.offsetHeight;

            // get container dimensions
            const container = elm.offsetParent;
            containerWidth = container.offsetWidth;
            containerHeight = container.offsetHeight;

            // get diff from (0,0) to mousedown point
            diffY = mouseY - elmY;
            diffX = mouseX - elmX;
        } else {
        }
    }

}


function mouseMove(e) {
    if (!isMouseDown) return;
    for (let i = 0; i < moveMe.length; i++) {
        if (i == e.currentTarget.idBox) {
            const elm = moveMe[e.currentTarget.idBox];
            console.log(elm);
            console.log(e.currentTarget.idBox);

            // get new mouse coordinates
            const newMouseY = e.clientY;
            const newMouseX = e.clientX;

            // calc new top, left pos of elm
            let newElmTop = newMouseY - diffY,
                newElmLeft = newMouseX - diffX;

            // calc new bottom, right pos of elm
            let newElmBottom = newElmTop + elmHeight,
                newElmRight = newElmLeft + elmWidth;

            if ((newElmTop < 0) || (newElmLeft < 0) || (newElmTop + elmHeight > containerHeight) || (newElmLeft + elmWidth > containerWidth)) {
                // if elm is being dragged off top of the container...
                if (newElmTop < 0) {
                    newElmTop = 0;
                }

                // if elm is being dragged off left of the container...
                if (newElmLeft < 0) {
                    newElmLeft = 0;
                }

                // if elm is being dragged off bottom of the container...
                if (newElmBottom > containerHeight) {
                    newElmTop = containerHeight - elmHeight;
                }

                // if elm is being dragged off right of the container...
                if (newElmRight > containerWidth) {
                    newElmLeft = containerWidth - elmWidth;
                }

            } else {

            }

            moveElm(elm, newElmTop, newElmLeft);
        } else {

        }

    }
}

// move elm
function moveElm(elm, yPos, xPos) {
    elm.style.top = yPos + 'px';
    elm.style.left = xPos + 'px';
}

function mouseUp() {
    isMouseDown = false;
}

for (let i = 0; i < moveMe.length; i++) {

    console.log(moveMe[i].id);
    console.log(i);

    moveMe[i].addEventListener('mousedown', mouseDown);
    moveMe[i].idBox = i;
    moveMe[i].addEventListener('mousemove', mouseMove);
    // moveMe[i].idBox = i;
    document.addEventListener('mouseup', mouseUp);
    // moveMe[i].idBox = i;

}

