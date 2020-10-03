// =================================================================
//
// togglediv.js is responsible for collapsing/expanding article descriptions
// in the SectionEx list.
//
// =================================================================
// toggleDiv.js sources were taken from various places from the web.
// The core part (toggleDiv and InitToggleDiv) is for example
// from www.codeproject.com with some minor modifications. I don't really
// know what licenses or copyrights I should put on this file. If you think that
// there is a problem using it ... then please don't do it.
// =================================================================
var ImgOpen = new Image();
var ImgClose = new Image();
//ImgOpen.src="./components/com_sectionex/clientside/plus.gif";
//ImgClose.src="./components/com_sectionex/clientside/minus.gif";

ImgOpen.src= se_theme_img + "plus.gif";
ImgClose.src= se_theme_img + "minus.gif";

//var divWrapper      = "seartcllist_wrap";
var divWrapper      = "section_ex";
var txtExpand 		= " Expand description";
var txtExpandAll 	= " Expand all descriptions";
var txtCollapse 	= " Collapse";
var txtCollapseAll 	= " Collapse all descriptions"
var bInitExpanded   = false;


// =================================================================================================================
// Helper methods for searching elements
// =================================================================================================================

// Javascript function that will return an array of elements based on DOM element, tag, and class name.
// For instance, getElementsByClassName(document, 'div', 'toggle') will get all "div" tags under the document node with the "toggle" class and return an array of them.
function getElementsByClassName(oElm, strTagName, strClassName)
{
	var arrElements = (strTagName == "*" && document.all) ? document.all : oElm.getElementsByTagName(strTagName);

	var arrReturnElements = new Array();
	strClassName = strClassName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strClassName + "(\\s|$)");
	var oElement;

	for(var i=0; i<arrElements.length; i++)
	{
		oElement = arrElements[i];
		if(oRegExp.test(oElement.className))
		{
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}


// Javascript function that will return an array of elements based on DOM element, tag, and ID name.
// For instance, getElementsByIdName(document, 'div', 'divimg') will get all "div" tags under the document node with the "divimg.." ID prefix and return an array of them.
function getElementsByIdName(oElm, strTagName, strIdName)
{
	var arrElements = (strTagName == "*" && document.all) ? document.all : oElm.getElementsByTagName(strTagName);

	var arrReturnElements = new Array();
	strIdName = strIdName.replace(/\-/g, "\\-");
	var oRegExp = new RegExp("(^|\\s)" + strIdName + "[0-9]*(\\s|$)");
	var oElement;

	for(var i=0; i<arrElements.length; i++)
	{
		oElement = arrElements[i];
		if(oRegExp.test(oElement.id))
		{
			arrReturnElements.push(oElement);
		}
	}
	return (arrReturnElements)
}


// =================================================================================================================
//Initialize "Expand", Expand all",.. (needed for internationalization support)
// =================================================================================================================

function initDescriptions()
{
	var spanExpd = document.getElementById("expand");
	var spanExpdAll = document.getElementById("expand_all");
	var spanClps = document.getElementById("collapse");
	var spanClpsAll = document.getElementById("collapse_all");
	var spanbInitExpanded = document.getElementById("init_expanded");

	if (document.all)
	{	// for IE
		txtExpand = " " + spanExpd.innerText;
		txtExpandAll = " " + spanExpdAll.innerText;
		txtCollapse = " " + spanClps.innerText;
		txtCollapseAll = " " + spanClpsAll.innerText;
		bInitExpanded = (spanbInitExpanded.innerText == "1");
	}
	else
	{	// for the rest of the known world
		txtExpand = spanExpd.textContent;
		txtExpandAll = spanExpdAll.textContent;
		txtCollapse = spanClps.textContent;
		txtCollapseAll = spanClpsAll.textContent;
		bInitExpanded = (spanbInitExpanded.textContent == "1");
	}
}

initDescriptions();



// =================================================================================================================
// Core part which turns all <div class="toggle"> into collapsable areas.
// =================================================================================================================

function toggleDiv()
{
    var id = this.getAttribute("divid");
    var divelm = document.getElementById("div" + id);
    var imgelm = document.getElementById("divimg" + id);
    var togelm = document.getElementById("divcollapse" + id);


    if (divelm.style.display != "none")
	{
        if (document.all)  togelm.innerText = txtExpand;
		else
		{
            document.getElementById("divmain" + id).className = "small";
            togelm.firstChild.nodeValue = txtExpand;
        }
        divelm.style.display = "none";
        imgelm.setAttribute("src", ImgOpen.src);
    }
	else
	{
        if (document.all) togelm.innerText = txtCollapse;
        else
		{
            document.getElementById("divmain" + id).className = "small";
            togelm.firstChild.nodeValue = txtCollapse;
        }
        divelm.style.display = "block";
        imgelm.setAttribute("src", ImgClose.src);
    }
}

function _addToggle( div, i )
{
      var main = document.createElement("div");
      main.style.width = "100%";
      main.setAttribute("id", "divmain" + i.toString());

      elm = document.createElement("img");
      elm.setAttribute("id", "divimg" + i.toString());
      elm.setAttribute("src", ImgClose.src);
      if (document.all) elm.style.cursor = "hand";
	  else elm.style.cursor = "pointer";
      elm.setAttribute("height", 9);
      elm.setAttribute("width", 9);
      elm.setAttribute("divid", i);
      elm.onclick = toggleDiv;

      main.appendChild(elm);

      elm = document.createElement("span");
      elm.setAttribute("id", "divcollapse" + i.toString());

      if (document.all)
	  {
          main.className = "small";
          elm.innerText = txtCollapse;
          elm.style.cursor = "hand";
      }
	  else
	  {
          main.className = "small";
		//This is lame. Why can't W3C just allow innerText on spans??
          var new_el = document.createTextNode(txtCollapse);
          elm.appendChild(new_el);
		  elm.style.cursor = "pointer";
      }

      elm.style.marginBottom = 0;
      elm.onclick = toggleDiv;
      elm.setAttribute("divid", i);

      main.appendChild(elm);

      div.setAttribute("id", "div" + i.toString());
      div.style.marginTop = 0;

      var parent = div.parentNode;
      parent.insertBefore(main, div);
}

function InitToggleDivReadMore()
{
    var articleText = document.getElementById( divWrapper );
	var divs 	= getElementsByClassName( articleText, "div", "toggle");
	var divsRM 	= getElementsByClassName( articleText, "div", "readmore");
	var count   = divsRM.length + divs.length;

	var cnt = 0;
    for (var i = divs.length; i < count; i++)
	{
	    //check if element already added, then dun add
	    var testObj = document.getElementById( 'divimg' + i );

	    if( testObj == null )
	    {
            _addToggle(divsRM[cnt], i);
        }
        cnt++;
    }
}


function InitToggleDiv()
{
    var articleText = document.getElementById( divWrapper );
	var divs = getElementsByClassName( articleText, "div", "toggle");


    for (var i = 0; i < divs.length; i++)
	{
	    //check if element already added, then dun add
	    var testObj = document.getElementById( 'divimg' + i );
	    
	    if( testObj == null )
	    {
            _addToggle(divs[i], i);
        }
    }
}

InitToggleDiv();



// =================================================================================================================
// Toggle (expand or collapse) all examples
// =================================================================================================================


function expandDivElemWithId(id, expanding)
{
    var divelm = document.getElementById("div" + id);
    var imgelm = document.getElementById("divimg" + id);
    var togelm = document.getElementById("divcollapse" + id);

    if (expanding == false)
	{
        if (document.all)  togelm.innerText = txtExpand;
		else
		{
            document.getElementById("divmain" + id).className = "small";
            togelm.firstChild.nodeValue = txtExpand;
        }
        divelm.style.display = "none";
        imgelm.setAttribute("src", ImgOpen.src);
    }
	else
	{
        if (document.all) togelm.innerText = txtCollapse;
        else
		{
            document.getElementById("divmain" + id).className = "small";
            togelm.firstChild.nodeValue = txtCollapse;
        }
        divelm.style.display = "block";
        imgelm.setAttribute("src", ImgClose.src);
    }
}


function expandAllDivElems(bIsExpandingAll)
{
	// -> expand / collapse all examples
	var articleText = document.getElementById( divWrapper );
	var divs = getElementsByIdName( articleText, "span", "divcollapse");
	for (var i = 0; i < divs.length; i++)
	{
		var id = divs[i].getAttribute("divid");
		expandDivElemWithId(id, bIsExpandingAll);
	}

	// ->  modify state of global expand / collapse button
	var spanToggleAll = document.getElementById("id_span_toggle_all");
	var imgToggleAll = document.getElementById("id_img_toggle_all");
	if (bIsExpandingAll == true)
	{
		spanToggleAll.textContent = txtCollapseAll;
		spanToggleAll.innerText = txtCollapseAll;
		imgToggleAll.setAttribute("src", ImgClose.src);
	}
	else
	{
		spanToggleAll.textContent = txtExpandAll;
		spanToggleAll.innerText = txtExpandAll;
		imgToggleAll.setAttribute("src", ImgOpen.src);
	}

	return 1;
}


function toggleAll()
{
	var imgToggleAll = document.getElementById("id_img_toggle_all");
	var picture = imgToggleAll.getAttribute("src");

	if (picture.match(/plus.gif/))
	{
		expandAllDivElems(true);
	}
	else
	{
		expandAllDivElems(false);
	}
}



function InitToggleAll()
{
	var spanToggleAll = document.getElementById("id_span_toggle_all");
	var imgToggleAll = document.getElementById("id_img_toggle_all");

	spanToggleAll.onclick = toggleAll;
	imgToggleAll.onclick = toggleAll;

	if (document.all)
	{
		spanToggleAll.style.cursor = "hand";
		imgToggleAll.style.cursor = "hand";
	}
	else
	{
		spanToggleAll.style.cursor = "pointer";
		imgToggleAll.style.cursor = "pointer";
	}


	// -> initially expand everything
	expandAllDivElems(bInitExpanded);
	return;
}

InitToggleAll();

