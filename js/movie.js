function Movie(){
	this.montages = new Array();
	this.screenlines = new Array();
	this.nums     = 0;
	this.length   = 0;
	this.screen   = "";
	this.time     = 0;
	this.bglines  = new Array("","","","","","","","");
	this.bikes     = new Array();
	this.interval ;
	this.moviediv ;
	this.running  = false;
	this.autostart = false;
	this.speed    = 256;
	Movie.self = this;
};
Movie.self;
Movie.prototype.screenheight = 8;
Movie.prototype.screenwidth  = 130;
Movie.prototype.add = function(montage){
	this.montages.push(montage);
};
Movie.prototype.init= function(moviediv){
	this.moviediv = moviediv;
	var montagesdiv = document.getElementById("montages").getElementsByTagName("pre");
	for( var i=0; i < montagesdiv.length ; i++){
		var montage = new Montage(montagesdiv[i].innerHTML.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&').replace(/&quot;/g,'"'));
		if( montage.formatted == true){
 		this.montages.push(montage);
 		this.nums++;
		}	
		else{
		alert("bad montage");
		}
	}
	var bikesdiv = document.getElementById("bikes").getElementsByTagName("pre");
	for( var i=0; i < bikesdiv.length ; i++ ){
		var bike = new Montage(bikesdiv[i].innerHTML.replace(/&lt;/g,'<').replace(/&gt;/g,'>').replace(/&amp;/g,'&').replace(/&quot;/g,'"'));
		if( bike.formatted == true){
 		this.bikes.push(bike);
		}	
		else{
		alert("bad bike");
		}
	}
};
Movie.prototype.run = function(){
		this.scrollfilm();
		this.nextframe();
		this.merge(this.bikes[this.time%this.bikes.length],50);
		this.time++;
		document.getElementById(this.moviediv).innerHTML= this.showscreen(); 
};
Movie.prototype.start = function(){
	this.running = true;
	this.interval = window.setInterval("Movie.self.run()",this.speed);
}
Movie.prototype.setSpeed = function(speed){
	this.speed = speed;
	window.clearInterval(this.interval);
	this.interval = window.setInterval("Movie.self.run()",this.speed);
}

Movie.prototype.stop = function(){
	this.running = false;
	window.clearInterval(this.interval);
}
Movie.prototype.scrollfilm = function(){
	while(this.length < this.screenwidth+20){
		this.addtofilm(this.montages[Math.floor(Math.random()*this.montages.length)]);
	}
};
Movie.prototype.showscreen= function(){
	this.screen   = "";
	for(var x in this.screenlines){
	//	this.screen = this.screen + this.screenlines[x].slice(0-this.screenwidth)+"\n";
		this.screen = this.screen + this.screenlines[x].slice(0,this.screenwidth)+"\n";
	}	
	return this.screen.slice(0,-1);
};
Movie.prototype.nextframe = function(){
	for(var  x in this.bglines ){
	//	this.bglines[x] = this.bglines[x].slice(0,-1);
		this.bglines[x] = this.bglines[x].slice(1);
	}	
	this.length =this.length - 1;
};
Movie.prototype.addtofilm = function(montage){
	for(var x=0; x < this.screenheight; x++ ){
		this.bglines[x] = this.bglines[x]+ montage.lines[x];
	}
	this.length = this.length + montage.length;
};
Movie.prototype.merge = function(montage,pos){
	pos = pos%this.screenwidth;
	this.screenlines = this.bglines.slice(0);
	for(var  x=0; x < this.screenheight; x++  ){
		for( var i=0; i< montage.length; i++){
			if( montage.lines[x][i] != ' '){
			this.screenlines[x] =  this.screenlines[x].slice(0,pos+i)+montage.lines[x][i]+this.screenlines[x].slice(pos+i+1);
			}
		}
	}	
};
function Montage(asciiart){
	this.lines = asciiart.split("\n");
	this.length = Math.max(this.lines[0].length,this.lines[1].length,this.lines[2].length,this.lines[3].length,this.lines[4].length,this.lines[5].length,this.lines[6].length,this.lines[7].length);
//	this.length = this.lines[0].length;
	this.height = this.lines.length;
	this.formatted  = true;
	if( this.height == 8){
		for(var x in this.lines){
			if( this.lines[x].length != this.length){
				this.formatted = false;
				break;
			}
		}
	}
	else{
		this.formatted = false;
	}
};
