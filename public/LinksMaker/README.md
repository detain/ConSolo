# LinksMaker
jQuery plugin to draw and save links between several lists of words compared 2 by 2

Work in progress : you can load, draw and save the links between several links

v 0.6 : Reorder elements by drag and drop


v 0.61 : correcting a bug preventing linking after exchanging columns when column A length > column B length
	
	
v 0.62 : mobile friendly idea by **Norman Tomlins** => make links more easily on touch devices just by clicking 

*Norman also provided the real life example of the demo page : colors for fiber cables to pair*

Tribute to **bolmaster2** on stackoverflow who wrote to is_touch_device() function 

This mobile behavious does not require any new option.


Demo : https://philippemarcmeyer.github.io/LinksMaker/index.html?v=0.62

## Notes :

LinksMaker derives from another plugin I made : FieldsLinker
Field linker was made to link the headers of import text files to database fields
it has an option I have droped in LinksMaker : mandatory fields on column B (the database column)
and automatic recognition of links by similarities in the names

Anyway, LinksMaker idea came from Colin Beech a fellow developer from NY
It allows you to make links between several lists that are drawn 2 a a time.

You pass an object to the plugin : 

```
let input = {...};
let myLinks=$("#bonds").linksMaker("init",input);
```

To retrieve the links :

You design a button and add a listener :

```
	$("#myBtnSave").on("click",function(){
		let results = myLinks.linksMaker("getLinks");
	});
```
you can JSON.stringify the result to save it in a database for instance

the object contains the following properties :

* existingLinks (optional) : If you have already stored links, you can reinput them here
* options (optional)
* Lists (mandatory) : an array of lists

### Lists :
A list is an object with a name and an array

```
{
	"name":"Fruits",
	"list" : [
		"Lemon",
		"Orange",
		"Cherry",
		"Banana",
		"Blackberry",
		"Kiwifruit",
		"Coconut",
		"Pineapple",
		"Lychee"
	]
}
```
Don't put twice the same element in a list, LinksMaker was not make for that (instead use fieldsLinker that allows it)

### Options :

#### handleColor : a string comma separated used to draw the links from top to bottom

the default list is "#CF0000,#00AD00,#0000AD,#FF4500,#00ADAD,#AD00AD,#582900,#FFCC00,#000000,#33FFCC"

#### className : default is "linksMaker"

#### lineStyle : "straight" or "square-ends"

#### oneToMany : "on" or "off" off the links have a 1 to 1 relationship, on : it would better be called many to many :-)

#### canvasTopOffset : default is 0 if you change the css you could (or not) shift the top of the canvas element where the links are drawn, use this option to "cheat"

#### buttonErase : no default. In the demo I use "Erase Links", If you provide this option you will get a button the erase links


### existingLinks : and saved links also.

Example :

```
"existingLinks" : {
	"links":
	[
		{"tables":"Fruits|Colors","from":"Lemon","to":"yellow"},
		{"tables":"Fruits|Colors","from":"Orange","to":"orange"},
		{"tables":"Fruits|Colors","from":"Kiwifruit","to":"green"},
		{"tables":"Vegetables|Colors","from":"carrot","to":"orange"}
	]
}
```

I don't know why I used the name "tables" but you understand it contains 2 items "|" separated which represent the column names

hint : "Fruits|Colors" is different form "Colors|Fruits"

More to come ...
