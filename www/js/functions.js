function testFunction() {
	alert('3');
}

function Node(val) {
	/*
		A node in a linked list, with values left and right. The list
		will most likely be circular
		val:the value the node in the linked list holds
		next: the next node in the list
		prev: the node previous
	*/
	this.val = val;
	this.next = null;
	this.prev = null;
	this.advance = null;
}
function getNext(node, num) {
	/*
		returns the value in a linked list to a certain 
		number of nodes in the forward direction
		node: a node in the linked list
		num: the number of nodes you still have to travel
	*/
	if(node == null)
		return null;
	else if(num<1)
		return node;
	else
		return getNext(node.next, num-1);
}
function getPrev(node, num) {
	/*
		returns the value in a linked list to a certain 
		number of nodes in the previous direction
		node: a node in the linked list
		num: the number of nodes you still have to travel
	*/
	if(node == null)
		return null;
	else if(num<1)
		return node;
	else
		return getPrev(node.prev, num-1);
}
function populateList(table, ring) {
	/*
		populates a linked list with values of a ring in order, 
		allowing for easily traversing through the board, then
		returns the upper left corner of the ring.
		table: the table the board is stored in
		ring: the ring number in the board (outer ring is 1, then works up as it gets closer)
	*/
	
	//the leftmost and rightmost nodes in the list
	var left = null;
	var right = null;
	var first = null;
	for(var i = 0; i<table.rows.length; i++) {
		var row = table.rows[i];
		var nodes = row.getElementsByClassName("ring-"+ring.toString());
		if(nodes.length==0)
			continue;
		//responsible for the top row in the board
		if(left == null || right == null) {
			left = new Node(nodes[0]);
			right = left;
			first = left;
			for(var j = 1; j<nodes.length; j++)
			{
				right.next = new Node(nodes[j]);
				right.next.prev = right;
				right = right.next;
			}
		}
		//all the other rows
		else {
			//has the left and right nodes work towards each other
			var j = 0;
			//loops until the two nodes would cross
			while(j < nodes.length-j) {
				//makes the leftmost and rightmost nodes the next in the list
				left.prev = new Node(nodes[j]);
				left.prev.next = left;
				left = left.prev;
				if(j!=nodes.length-j-1)
				{
					right.next = new Node(nodes[nodes.length-j-1]);
					right.next.prev = right;
					right = right.next;
				}
				//only happens if the length of cells is odd 
				//(basically when left and right would cross)
				else 
				{
					left.prev = right;
					right.next = left;
				}
				j++;
			}
		}
	}
	//makes the ring circular if it is not already
	//(will happen if the number of cells in the row is even)
	if(right.next == null || left.prev == null)
	{
		left.prev = right;
		right.next = left;	
	}
	//returns the upperleft corner
	return first;
}
function populateBoard(table, rings) {
	/*
		populates the board to be a linked list between rings
	*/
	
	//creates the list of rows
	var board=new Array();
	for(var i=0; i<rings; i++) 
	{
		var node = populateList(table,i+1);
		board[i]=node;
		
		//updates all the center positions to allow the user to advance a space
		var length=listLength(node,node);
		node = getNext(node,length/8);
		for(var j=0; j<4; j++)
		{
			node.val.className+=' advanceSpot';
			node=getNext(node,length/4);
		}
	}
	
	//loops through all the rows and has them advance towards the center
	for(var i=0; i<board.length-1; i++)
	{
		var rowSpot = board[i].prev;
		var nextRowSpot = board[i+1];
		var ringLength = listLength(board[i+1],board[i+1]);
		var positionId=" west";
		for(var j=0; j<ringLength; j++)
		{
			//handles corners
			if(j%(ringLength/4)==0)
			{
				rowSpot.advance = nextRowSpot
				rowSpot.val.className+=positionId;
				rowSpot=rowSpot.next;
				rowSpot.val.className+=positionId;
				rowSpot.advance = nextRowSpot;
				switch(j*4/ringLength) {
					case 0:
						positionId=" north";
						rowSpot.val.className+=positionId;
						break;
					case 1:
						positionId=" east";
						rowSpot.val.className+=positionId;
						break;
					case 2:
						positionId=" south";
						rowSpot.val.className+=positionId;
						break;
					case 3:
						positionId=" west";
						rowSpot.val.className+=positionId;
						break;
				}
				rowSpot=rowSpot.next;
			}
			
			//points towards the center
			rowSpot.val.className+=positionId;
			rowSpot.advance = nextRowSpot
			rowSpot=rowSpot.next;
			nextRowSpot=nextRowSpot.next;
		}
	}
	
	//has the center row point to the final question
	var rowSpot = board[board.length-1];
	var ringLength = listLength(rowSpot,rowSpot);
	var currSpot = rowSpot;
	window.middle = table.getElementsByClassName("finalQuestion")[0];
	var j=0;
	var positionId=" west";
	do {
		currSpot.val.className+=positionId;
		if(j%(ringLength/4)==0)
		{
			switch(j*4/ringLength) {
				case 0:
					positionId=" north";
					currSpot.val.className+=positionId;
					break;
				case 1:
					positionId=" east";
					currSpot.val.className+=positionId;
					break;
				case 2:
					positionId=" south";
					currSpot.val.className+=positionId;
					break;
				case 3:
					positionId=" west";
					currSpot.val.className+=positionId;
					break;
			}
		}
		currSpot.advance = middle
		currSpot = currSpot.next;
		j++;
	}while(currSpot!=rowSpot);
	return board[0];
}
function listLength(node, startNode)
{
	/*
	* returns the length of a list of nodes
	*/
	if(node.next == null)
		return 1;
	else if(node.next == startNode)
		return 1;
	else
		return 1 + listLength(node.next, startNode);
}
function initialize(table,rings,dbCategoryIds,dbCategories,players) 
{
	/*
	 * initializes the table when given the table the php file creates,
	 * the number of rings, the the categories, and the number of players
	 */
	 
	//populates the entire board as a linked list and puts it to one node
	var firstNode = populateBoard(table,rings);
	window.player = new Array();
	window.questionCorrect=false;
	
	//initializes the players
	for(var i=0; i<players; i++)
	{
		window.player[i] = firstNode;
		window.player[i].val.childNodes[1].innerHTML += "<span id='player-"+(i+1)+"'>&nbsp</span>";
	}
	
	//initializes a few basic values
	window.currentPlayer=0;
	window.totalPlayers=players
	window.boardStart = window.player[window.currentPlayer];
	window.categories = dbCategories;
	window.categoryIds = dbCategoryIds;
	
	//populates the board with categories of quesitons
	populateWithQuestions();
	
	//populates the center of the board with information on the current player and their roll
	var checkCommand = "<div id='currentPlayer'></div>"+
		"<a onclick=\"roll();\">Click to roll the die.</a>";
	table.getElementsByClassName("finalQuestion")[0].innerHTML=checkCommand;
	document.getElementById('currentPlayer').innerHTML="Player "+(window.currentPlayer+1)+"'s turn";
}
function nextNodes() {
	var nodePlayers = window.player[window.currentPlayer].val.childNodes[1].innerHTML;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML = nodePlayers.replace('<span id="player-'+(window.currentPlayer+1)+'">&nbsp;</span>',"");
	window.player[window.currentPlayer]=window.player[window.currentPlayer].next;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML += "<span id='player-"+(window.currentPlayer+1)+"'>&nbsp;</span>";
}
function prevNodes() {
	var nodePlayers = window.player[window.currentPlayer].val.childNodes[1].innerHTML;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML = nodePlayers.replace('<span id="player-'+(window.currentPlayer+1)+'">&nbsp;</span>',"");
	window.player[window.currentPlayer]=window.player[window.currentPlayer].prev;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML += "<span id='player-"+(window.currentPlayer+1)+"'>&nbsp;</span>";
}
function advanceNodes() {
	/*
	 * advances the node towards the center, and calls the win screen if the player wins
	 */
	var nodePlayers = window.player[window.currentPlayer].val.childNodes[1].innerHTML;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML = nodePlayers.replace('<span id="player-'+(window.currentPlayer+1)+'">&nbsp;</span>',"");
	if(window.player[window.currentPlayer].advance == window.middle)
		win();
	else
		window.player[window.currentPlayer]=window.player[window.currentPlayer].advance;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML += "<span id='player-"+(window.currentPlayer+1)+"'>&nbsp;</span>";
}
function roll() {
	/*
	 * Rolls the die (will hopefully have dice images soon!),
	 * then initializes areas for the player to click to choose the direction
	 * to move to
	 */
	if(document.getElementsByClassName("nextSpot").length!=0)
		return false;
	var rollBox = document.getElementById('rollBox');
	window.rollVal = Math.floor(Math.random()*6)+1;
	if(rollBox != null)
		rollBox.innerHTML=window.rollVal.toString();
	else
		window.middle.innerHTML+='<div id="rollBox">'+window.rollVal.toString()+'</div>';
	var next = getNext(window.player[window.currentPlayer],window.rollVal);
	next.val.innerHTML+="<a onclick=\"move('next');\">Move Here</a>";
	next.val.className+=" nextSpot";
	var prev = getPrev(window.player[window.currentPlayer],window.rollVal);
	prev.val.innerHTML+="<a onclick=\"move('prev');\">Move Here</a>";
	prev.val.className+=" nextSpot";
	//document.getElementById('lightbox').innerHTML='<div id="rollBox">'+window.rollVal.toString()+'</div>';
	//document.getElementById('lightbox-container').className='showing';
}
function move(direction) {
	/*
	 * Moves, based on the direction the player chooses to move in.
	 * Then, it will prompt the user with an appropriate quesiton
	 */
	var nodePlayers = window.player[window.currentPlayer].val.childNodes[1].innerHTML;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML = nodePlayers.replace('<span id="player-'+(window.currentPlayer+1)+'">&nbsp;</span>',"");
	var next = getNext(window.player[window.currentPlayer],window.rollVal);
	var prev = getPrev(window.player[window.currentPlayer],window.rollVal);
	var moveSpots=document.getElementsByClassName("nextSpot");
	while (moveSpots.length!=0)
	{
		moveSpots[0].innerHTML=moveSpots[0].innerHTML.replace("<a onclick=\"move('next');\">Move Here</a>","");
		moveSpots[0].innerHTML=moveSpots[0].innerHTML.replace("<a onclick=\"move('prev');\">Move Here</a>","");
		moveSpots[0].className=moveSpots[0].className.replace(" nextSpot","");
	}
	if(direction == 'next')
		window.player[window.currentPlayer] = next;
	else if(direction == 'prev')
		window.player[window.currentPlayer] = prev;
	window.player[window.currentPlayer].val.childNodes[1].innerHTML += "<span id='player-"+(window.currentPlayer+1)+"'>&nbsp;</span>";
	getQuestion(window.player[window.currentPlayer].val);
}
function populateWithQuestions() {
	/*
	 * Populates each piece on the board with a specific category.
	 */
	var nodePosition = window.boardStart;
	var i = 0;
	while(nodePosition != window.middle)
	{
		nodePosition.val.id = window.categories[i];
		nodePosition.val.childNodes[0].innerHTML = window.categories[i];
		i++;
		if(i>=window.categories.length)
			i = 0;
		nodePosition=nodePosition.next;
		if(nodePosition.val.id != "")
		{
			nodePosition = nodePosition.advance;
		}
	}
}
function getQuestion(boardPosition) {
	/*
	 * Sets the lightbox to contain an iframe, and then posts 
	 * to it the category of question to use
	 */
	document.getElementById('lightbox').innerHTML='<iframe id="magic_frame" name="magic_frame" width="100%" height="100%"></iframe>';//'<div id="question">'+question+'</div>';
	document.getElementById('lightbox-container').className='showing';
	
	document.forms["magic_form"].category_id.value=window.categoryIds[window.categories.indexOf(boardPosition.id)];
	document.forms["magic_form"].submit();
	
}
function disappear() {
	/*
	 * Makes the lightbox disappear (CSS!)
	 */
	document.getElementById("lightbox-container").className='';
}
function win() {
	/*
	 * Ends the game and shows the winner
	 */
	document.getElementById('lightbox').innerHTML='<h1 style="text-align:center; margin:25px;">Congratulations Player '+(window.currentPlayer+1)+
		', you won the game! Go brag to others about how well you know house history!</h1><br><p style="text-align:center;"><a href="#" onclick="disappear();">Click here to exit</a></p>';
	window.middle.innerHTML="";
	document.getElementById('lightbox-container').onclick=new function() {disappear()};
	window.parent.document.getElementById('lightbox-container').className='showing';
}
function instructions() {
	/*
	 * Shows the player the instructions using the lightbox. This
	 * is basically taken straight from the about page.
	 */
	document.getElementById('lightbox').innerHTML='<p style="margin:25px;">'+
			"Wicked Awesome History (<strong>WAH</strong>) is a board game similar to <a href=\"http://boardgamegeek.com/boardgame/1362/wits-end\" target=\"blank\">Wits End</a>."+
			"It is a trivia game that is (supposed to be) based around house history and stories, although the form is set up so that you can post any kind of questions or"+
			"nonesense you want. It's a fairly simple game. You roll the die to determine how far you move. You move that distance in either one direction or the other, you"+
			"chose. When you land on a spot, you answer a question about that category of history. If you get it correct, you roll again. If you fail and get it wrong, the "+
			"next player rolls. If you answer a question correctly on an advance square (located at the center of each side of the board), then you advance closer to the center."+
			"If you make it to the center, you win!"+
		'</p>'+
		'<a style="margin:0 25px;" onclick="disappear();">Click here to exit</a></p>';
	document.getElementById('lightbox-container').onclick=new function() {disappear()};
	window.parent.document.getElementById('lightbox-container').className='showing';
}