/*Setting 
Variables*/

var myName = "Jonah"    //Var can be used throughout your entire program and can be changed
myName = "John"     //Var is changed to John

let hisName = "Jeremy"  //Let can only be used in the scope where you declared the variable

const otherName = "Jimmy"   //Const is a variable that can never change




/*Declaring and 
Assigning Variables*/

var a;  //This is declaring the variable a, alse called an uninitialized variable, not having a value

a = 2;  //This is assigning the number 2 to variable a

var b = 3;

console.log(a); //This will show you the contents of variable a in the console when ran
console.log(b); //If you console.log two variables, it will show both in the console when ran




/* Using Math
 Operators*/

 var sum = 10 + 10;
 var difference = 45-20;
 var product = 8 * 3;
 var quotient = 60 / 5;

 console.log(sum);
 console.log(difference);
 console.log(product);
 console.log(quotient);

 //Incrementing: To add 1 to any value assigned to a variable (++)
 var myVar = 87;
 myVar = myVar + 1; //Easier way to do this is myVar = myVar++;

 //Decrementing: Same thing as incrementing, but with subtraction
 myVar = myVar - 1; //myVar--;




/* Augmented Math 
 Operations */

 var d = 3;
 //instead of writing out the equation, there are easier ways to put it

 d = d + 12;
 //d += 12;
 d = d - 12;
 //d -+ 12;
 d = d * 12;
 //d *= 12;
 d = d / 12;
 //d /= 12;




/* Escaping 
 Literal Quotes */

 //var myString = "I am a "double quoted" string inside "double quotes"";  THIS IS THE EXAMPLE

 //This line confuses js, so you can get rid of quotes by escaping:
 //Js now knows that the first set of quotes is not the end of a string. If you console.log, it won't show the slashes

 var myString = "I am a \"double quoted\" string inside \"double quotes";

 //You can also use single quotes to do this:

 var myString = 'I am a "double quoted" string inside "double quotes"';



/* String
 Concatenation */

 var ourString = "I was. ";
 ourString += "I am.";
//console.log(ourString) = I was. I am.




/* Concatenating Strings
    with Variables */

var nameOne = "Jonah";
var stringOne = "Hello, my name is " + nameOne + ", how are you?";

//console.log(stringOne) = Hello, my name is Jonah, how are you?




/* Appending Variables
    to Strings*/

var objectiveOne = "awesome!";
var objectiveString = "My day was ";
objectiveString += objectiveOne;
//Result = My day was awesome!




/* Find Length
    of String */

var firstNameLength = 0;
var firstName = "Jonah";

firstNameLength = firstName.length;
//Will return 5




/* Bracket Notation to Find
    String Letters by Number */

var firstName = "Jonah";
var firstLetterOfFirstName = firstName[0];
//Will return "J"

//String literals are immutable, meaning that they cannot be changed, but can be fixed
var myStr = "Jello world";
myStr = "Hello world";
//Returns "Hello world"




/* Creating 
Sentences */

function wordBlanks(myNoun, myAdjective, myVerb, myAdverb) {
    //This will be like Mad Libs, where you have to create your own sentence
    var result = "";
    result += "The " + myAdjective + " " + myNoun + " " + myVerb + " " + myAdverb + " to the store."
    return result;
}

//console.log(wordBlanks("dog", "big", "ran", "quickly")) = The big dog ran quickly to the store.




/* Arrays */

var myArray = [50,60,70];
var myData = myArray[0]; //This is an index, which finds a value in an array.
console.log(myData); //This would return 50

//Modify array data

var ourArray = [50,60,70];
ourArray[1] = 65; //Array now equals [50,65,70]
 



/* SCOPE */

//Scope refers to how far variables can be used in your code

//If a variable is declared inside of a function, it can only be used in that function
//If a variable is declared outside of a function, it can be used anywhere in the code

//Random Practice

var obj1 = 42;
var obj2 = 68;
var obj3 = 80;

var sum = "The sum of the objects is: " + (obj1 + obj2 + obj3);
var difference = "The difference of all three objects is: " + (obj3 - obj2 - obj1);
var product = "The product of the objects is: " + (obj1 * obj2 * obj3);
var quotient = "The quotient of objects 1 and 2 are: " + (obj1 / obj2);

console.log(sum);
console.log(difference);
console.log(product);
console.log(quotient);

var field1 = "text";
var myData = [field1, "2", "field3"];
var myChart = ["row1", "row2", "row3"];
var myArray = ["four", "five", "six"];

console.log(myData[0]);
console.log(myChart[1]);
console.log(myArray[2]); 




/* Booleans */

//Booleans only have two values: True or False

function welcomeToBooleans() {
    return false;
}

console.log(welcomeToBooleans())
//Returns false




/* IF Statements */

function ourTrueOrFalse(isItTrue) {
    if(isItTrue) {
        return "Yes, it's true";
    }
    return "No, it's false";
}

function trueOrFalse(wasThatTrue) {
    if(wasThatTrue) {
        return "Yes, that was true";
    }
    return "No, that was false";
}

console.log(trueOrFalse(true));
//Will return: Yes, that was true

//Equality Operator

function testEqual(val) {
    if(val == 12) {     //== just means =. If you used = here, it would think that you are assigning a variable
        return "Equal";
    }
    return "Not Equal";
}

console.log(testEqual(10));
//Will return Not Equal




/* Strict Equality Operator*/

function testStrict(val) {
    if (val === 3) {      // === asks if both values are equal and the same type. So 3 as a number and '3' as a string will not be equal here, but 3 and 3 will be
        return "Equal";
    }
    return "Not Equal";
}

console.log(testStrict('3'));
//Will return Not Equal

/* Compare Equality (Equality Operator) */

function compareEquality(a,b) {
    if (a === b) {
        return "Equal";
    }
    return "Not Equal";
}

console.log(compareEquality(10,'10'));
//Will return Not Equal

/* Compare Inequality (Inequality Operator */

function testNotEqual(val) {
    if (val != 99) {        //Strict Equality Operator also exists (!==)
        return "Not Equal";
    }
    return "Equal";
}
console.log(testNotEqual(10));
//Will return Not Equal

//Greater Than

function testGreaterThan(val) {
    if (val > 100) {
        return "Over 100";
    }
    if (val > 10) {
        return "Over 10";
    }
    return "10 and Under";
}

console.log(testGreaterThan(1));
//Will return 10 and Under




/* More Operators */

// And/Or Operators

//AND Operator

function testLogicalAnd(val) {
    if (val <= 50 && val >= 25) {  // The && just means AND
        return "Yes";
    }
    return "No";
}

console.log(testLogicalAnd(25));

//OR Operator

function testLogicalOr(val) {
    if (val < 10 || val > 20) {
        return "Outside";
    }
    return "Inside";
}

console.log(testLogicalOr(25));

// ELSE Statement

function testElse(val) {
    var result = "";

    if (val > 5) {
        result = "Bigger than 5";
    }
    else {
        result = "5 or smaller";
    }
    return result;
}  

console.log(testElse(6))

// ELSEIF Statement  **Order of statements is very important**

function testElseIF(val) {
    var result = "";

    if (val > 5) {
        if (val > 10) {
        result = "Bigger than 5";
    }   else if (val < 5) {
        result = "Smaller than 5";
    }   else {
        return "Between 5 and 10";
    }
}  
}

console.log(testElseIF(6))

//Chained ElseIf Statements

function testSize(num) {

if (num < 5) {
    return "Tiny";
}  else if (num < 10) {
   return "Small";
}  else if (num < 15) {
   return "Medium";
}  else if (num < 20) {
   return "Large";
}  else {
   return "Huge";
}
}
console.log(testSize(19));




/* OBJECTS */

var myDog = {       //This is an object!! Dumb easy
    "name" : "Dusty",
    "legs" : 4,
    "tails" : 1,
    "friends" : "Many"
};

//Dot Notation (Using attributes of an object)

var dogName = myDog.name;
var dogFriends = myDog.friends

console.log(dogFriends);