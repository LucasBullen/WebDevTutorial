
/*
	Will randomly change the colors of the three sections
	when a button is clicked
*/
function changeColors() {

	console.log("Button Pressed");

	var sections = document.getElementsByClassName('section');
	for (var i = sections.length - 1; i >= 0; i--) {
		var randomColor = getRandomColor();
		sections[i].style.background = randomColor
		if(i == 1 ){
			/****************************************************
				We want to change the title color to white when
				the background color is dark, and black when the
				background color is light.
				Create an if statement here to make this happen
			****************************************************/
			if(isColorLight(randomColor)){
				
			}else{
				
			}
		}
	}
}

/****************************************************
	BONUS: Sort the rows in the history table
****************************************************/


/*
	Returns a randomized hex code for a color
*/
function getRandomColor() {
    var letters = '0123456789ABCDEF';
    var color = '#';
    //	Chooses 6 random hex digits to create the hex code with
    for (var i = 0; i < 6; i++ ) {
        color += letters[Math.floor(Math.random() * 16)];
    }
    return color;
}

/*
	Takes a hex code for a color and returns TRUE if it is
	above a certain level of brightness and FALSE otherwise
*/
function isColorLight(c) {
	var c = c.substring(1);		// strip #
	var rgb = parseInt(c, 16);	// convert rrggbb to decimal
	var r = (rgb >> 16) & 0xff;	// extract red
	var g = (rgb >>  8) & 0xff;	// extract green
	var b = (rgb >>  0) & 0xff;	// extract blue

								// per ITU-R BT.709
	var luma = 0.2126 * r + 0.7152 * g + 0.0722 * b;
	return luma < 100			//return true if too light
}