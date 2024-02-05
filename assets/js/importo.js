var n_umeri = new Array(28);
for(i=0;i<=20;i++){
n_umeri[i]=i;
}
n_umeri[21]=30;
n_umeri[22]=40;
n_umeri[23]=50;
n_umeri[24]=60;
n_umeri[25]=70;
n_umeri[26]=80;
n_umeri[27]=90;
n_umeri[28]=1000;
l_ettera=new Array("zero","uno","due","tre","quattro","cinque","sei","sette","otto","nove","dieci","undici","dodici","tredici","quattordici","quindici","sedici","diciassette","diciotto","diciannove","venti","trenta","quaranta","cinquanta","sessanta","settanta","ottanta","novanta","mille");

function conv_iac(fn){
var resto;
var vsc;
var vst2 = "";
var vst3 = "";
var vst4 = "";
var vst5 = "";

var n0=0;
var n1=0;
var n2=0;

var vst0 = "";

fn=fn.replace(',','.');
resto = fn - parseInt(fn);

fn = parseInt(fn);

vsc=cerca(fn,n_umeri);

	if (vsc == -1) {


		if (fn>=1000000000) {
			n0=Math.floor(fn/1000000000);
			vst0=dividi(n0);
			fn=fn % 1000000000;
			n1=n0 % 100;
			if (n1==1) vst5="unmiliardo";
			else vst5=vst0+"miliardi";
			n1=0;
		 }

		if (fn>=1000000) {
		        n0=Math.floor(fn/1000000);
			vst0=dividi(n0);
			fn= fn % 1000000;
			n1=n0 % 100;
		        if (n1==1) vst4="unmilione";
		        else vst4 = vst0+"milioni";
			n1=0;
		}
		if (fn>=1000){
			n0=Math.floor(fn/1000);
			vst0=dividi(n0);
			fn=fn % 1000;
			n1=n0 % 100;
			n0=Math.floor(n0/100);
			n2=n0 % 10;
			if (n1==1 && n2==0)
      			vst3="mille";
		        else
		        vst3=vst0+"mila";
		}
		if (fn<1000) {
			 n0=fn;
			 vst0=dividi(n0);
			 vst2=vst0;
		}
	fl=vst5+vst4+vst3+vst2;
	} else {
		fl=l_ettera[vsc];
	}
resto = Math.round(resto*100);
if (resto<10)
resto="0"+resto;
return (fl+"/"+resto);
//document.getElementById("risultato").innerHTML = (fl+"/"+resto);
}


function cerca(fn,arra) {
	for (i = 0; i < arra.length; i++) {
	if (fn == arra[i]) return i;
	}
return -1;
}

function dividi(n0) {
var nd;
var vst0;

vst0="";
n1=n0 % 100;
n0=Math.floor(n0/100);
n2=n0 % 10;
n0=Math.floor(n0/10);
	if (n2!=0){
		vsc=cerca(n2,n_umeri);
		if (n2==1) vst0="cento";
		else vst0=l_ettera[vsc]+"cento";
	}

	if (n1!=0){
		vsc=cerca(n1,n_umeri);

		if (vsc==-1){
			nd=Math.floor(n1/10)*10;

			vsc=cerca(nd,n_umeri);
			nd=n1-nd;
			if (nd==1 || nd==8)
			vst0=vst0+l_ettera[vsc].substring(0,(l_ettera[vsc].length-1));
			else
			vst0=vst0+l_ettera[vsc];
			vsc=cerca(nd,n_umeri);
			vst0=vst0+l_ettera[vsc];
			} else {
		vst0=vst0+l_ettera[vsc];
		}
	}
return vst0;
}