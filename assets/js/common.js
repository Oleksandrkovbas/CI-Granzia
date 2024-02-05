function confirmDeleteRecords(controller)
{
	//with(frm)
	{
		var flag = false;
		str = '';
		field = document.getElementsByName('c_list[]');
		for (i = 0; i < field.length; i++)
		{
			if(field[i].checked == true)
			{
				flag = true;
				break;
			}
			else
				field[i].checked = false;
		}
		if(flag == false)
		{
			alert("Please select atleast one record to delete.");
			return false;
		}
	}

	var agree=confirm("Are you sure to delete the selected record(s) ?");
	if (agree)
	{
		document.getElementById('action').value = "deleteselected";
		$('#listing-form').attr('action', base_url+controller+'/deleteselected');
		document.getElementById('listing-form').submit();
		return true ;
	}
	else
		return false ;
}

function confirmDeleteRecord(controller, c_id)
{
	//with(frm)
	{
		//var agree=confirm("Are you sure to delete this record ?");
		//if (agree)
		{
			document.getElementById('pk_id').value = c_id;
			document.getElementById('action').value = "delete";
			$('#listing-form').attr('action', base_url+controller+'/delete');
			document.getElementById('listing-form').submit();
		}
	}
}

function confirmDeleteRecordForAppendix(controller, c_id)
{
	//with(frm)
	{
		//var agree=confirm("Are you sure to delete this record ?");
		//if (agree)
		{
			document.getElementById('ak_id').value = c_id;
			document.getElementById('action').value = "delete";
			$('#listing-form').attr('action', base_url+controller+'/delete');
			document.getElementById('listing-form').submit();
		}
	}
}


function changeStatus(controller, p_id, status)
{
	//with(frm)
	{
		document.getElementById('pk_id').value = p_id;
		document.getElementById('action').value = "changestatus";
		document.getElementById('status').value = status;
		$('#listing-form').attr('action', base_url+controller+'/changestatus');
		document.getElementById('listing-form').submit();
	}
}

function isNumberKey(evt) {
    var charCode = (evt.which) ? evt.which : event.keyCode;
    if (charCode != 46 && charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    } else {
        return true;
    }
}

function ValidateSearchForm()
{
    if(document.getElementById('filter_fromdate').value == '')
    {
        alert("Please enter from date");
        document.getElementById('filter_fromdate').focus();
        return false;
    }
    if(document.getElementById('filter_todate').value == '')
    {
        alert("Please enter to date");
        document.getElementById('filter_todate').focus();
        return false;
    }
    return true;
}

// Convert numbers to words
// copyright 25th July 2006, by Stephen Chapman http://javascript.about.com
// permission to use this Javascript on your web page is granted
// provided that all of the code (including this copyright notice) is
// used exactly as shown (you can change the numbering system if you wish)

// American Numbering System
var th = ['', 'thousand', 'million', 'billion', 'trillion'];
// uncomment this line for English Number System
// var th = ['','thousand','million', 'milliard','billion'];

var dg = ['zero', 'one', 'two', 'three', 'four', 'five', 'six', 'seven', 'eight', 'nine'];
var tn = ['ten', 'eleven', 'twelve', 'thirteen', 'fourteen', 'fifteen', 'sixteen', 'seventeen', 'eighteen', 'nineteen'];
var tw = ['twenty', 'thirty', 'forty', 'fifty', 'sixty', 'seventy', 'eighty', 'ninety'];

function toWords(s) {

    s = s.toString();
    s = s.replace(/[\, ]/g, '');
    if (s != parseFloat(s)) return 'not a number';
    var x = s.indexOf('.');
	var fulllength=s.length;
	
    if (x == -1) x = s.length;
    if (x > 15) return 'too big';
	var startpos=fulllength-(fulllength-x-1);
    var n = s.split('');
	
    var str = '';
    var str1 = ''; //i added another word called cent
    var sk = 0;
    for (var i = 0; i < x; i++) {
        if ((x - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';

                sk = 1;
            }
        } else if (n[i] != 0) {
            str += dg[n[i]] + ' ';
            if ((x - i) % 3 == 0) str += 'hundred ';
            sk = 1;
        }
        if ((x - i) % 3 == 1) {
            if (sk) str += th[(x - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    if (x != s.length) {
        
        str += 'and '; //i change the word point to and 
        str1 += 'cents '; //i added another word called cent
        //for (var i = x + 1; i < y; i++) str += dg[n[i]] + ' ' ;
		 var j=startpos;
		
		 for (var i = j; i < fulllength; i++) {
		 
        if ((fulllength - i) % 3 == 2) {
            if (n[i] == '1') {
                str += tn[Number(n[i + 1])] + ' ';
                i++;
                sk = 1;
            } else if (n[i] != 0) {
                str += tw[n[i] - 2] + ' ';
				
                sk = 1;
            }
        } else if (n[i] != 0) {
		
            str += dg[n[i]] + ' ';
            if ((fulllength - i) % 3 == 0) str += 'hundred ';
            sk = 1;
        }
        if ((fulllength - i) % 3 == 1) {
		
            if (sk) str += th[(fulllength - i - 1) / 3] + ' ';
            sk = 0;
        }
    }
    }
	
	var gs_str = "";
	var result=str.replace(/\s+/g, ' ') + str1;
	//alert(result);
	
	const myArray = result.split(" and");
	
	/*console.log(str);
	console.log("=======");
	console.log(myArray);
	console.log(myArray[2]);
	const fw = myArray.slice(-1);
	console.log(fw);*/
	
	 
	// var str = "I want to remove the last word.";
	/*var str = fw.toString();
	var lastIndex = str.lastIndexOf(" ");
	
	str = str.substring(0, lastIndex);
	console.log(str);*/
	
	//var p = myArray[2].substring(0, myArray[2].lastIndexOf(" "));
	//console.log("hello"+p);
	//var eng_num = inWords(str);
	//console.log("piyush="+eng_num);
	
	const rArr = s.split(".");
	//console.log(rArr);
	//console.log("rana="+rArr[1]);
	if(rArr[1]!=undefined){
		console.log(myArray[0]+"/"+rArr[1]);
		var new_result = myArray[0].trim()+"/"+rArr[1];
	}
	else{
		console.log("shanu="+myArray[0].trim());
		var new_result = myArray[0].trim()+"/00";
	}
    //return str.replace(/\s+/g, ' ');
	//$('#risultato').text(result);
   // return result; //i added the word cent to the last part of the return value to get desired output
	return new_result;
}

var a = ['','one ','two ','three ','four ', 'five ','six ','seven ','eight ','nine ','ten ','eleven ','twelve ','thirteen ','fourteen ','fifteen ','sixteen ','seventeen ','eighteen ','nineteen '];
var b = ['', '', 'twenty','thirty','forty','fifty', 'sixty','seventy','eighty','ninety'];

function inWords (num) {
	
	if ((num = num.toString()).length > 9) return 'overflow';
    n = ('000000000' + num).substr(-9).match(/^(\d{2})(\d{2})(\d{2})(\d{1})(\d{2})$/);
    if (!n) return; var str = '';
    str += (n[1] != 0) ? (a[Number(n[1])] || b[n[1][0]] + ' ' + a[n[1][1]]) + 'crore ' : '';
    str += (n[2] != 0) ? (a[Number(n[2])] || b[n[2][0]] + ' ' + a[n[2][1]]) + 'lakh ' : '';
    str += (n[3] != 0) ? (a[Number(n[3])] || b[n[3][0]] + ' ' + a[n[3][1]]) + 'thousand ' : '';
    str += (n[4] != 0) ? (a[Number(n[4])] || b[n[4][0]] + ' ' + a[n[4][1]]) + 'hundred ' : '';
    str += (n[5] != 0) ? ((str != '') ? 'and ' : '') + (a[Number(n[5])] || b[n[5][0]] + ' ' + a[n[5][1]]) + 'only ' : '';
    return str;
}



function showPinModal(route = "") {
  if (window.location.href == route) {
    return true;
  } else {
    $("#pinModal").modal("show");
  }
}

function allowRoute(route = "", pin = "") {
  if (pin == "2828") {
    window.location.href = route;
  }
}

function enterKeyEvent(element, route = "", pin = "") {
  if (event.key == "Enter") {
    allowRoute(route, pin);
  }
}
