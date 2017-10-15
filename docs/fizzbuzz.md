# FizzBuzz

## Initial challenge

FizzBuzz is a typical interview question that you'll come across. It's a fairly
simple challnge with a few basic rules:

You need to print all the numbers from 1 through 100 except:

* if the number is divisible to 3, print 'fizz'
* if the number is divisible to 5, print 'buzz'
* if the number is divisible by both 3 and 5, print 'fizzbuzz'
(only print the number if it's not divisible by 3 or 5)

To approach this challenge, make a new php file in your `public` directory that
meets the above requirements. Try to separate your code into small functions
that you can easily test. Make sure to add a php script to the `tests` 
directory and make it run your functions and verify that they produce the
correct results.


## Adding user input

Once you've completed the initial challenge, we're going to build on it and
add some user input. Change your page so that it doesn't automatically
display the output, but instead gives the user a text box where they can
input two numbers. Then use these numbers as lower and upper limits. 
For example, if they enter `52` as the lower limit, and `267` as the upper
limit, you should iterate the numbers `52` through `267` instead of 1 through
100, make sure you update your tests!


## Adding another word

Now update your script to add the word 'zapp' if the number is divisible by 7.
This adds quite a lot of complexity to your code, so make sure you structure
it cleanly, with lots of small functions that only do one thing. It might
also be a good idea to consider an object-oriented approach and build some 
classes to help you.

So your requirements now look like this:

Take a lower and an upper limit from the user, output the numbers from the 
lower limit to the upper limit unless:

* the number is divisible by 3, print 'fizz'
* the number is divisible by 5, print 'buzz'
* the number is divisible by 7, print 'zapp'
* the nmuber is divisible by 3 and 5, print 'fizzbuzz'
* the number is divisible by 3 and 7, print 'fizzzapp'
* the number is divisible by 5 and 7, print 'buzzzapp'
* the number is divisible by 3, 5 and 7, print 'fizzbuzzzapp'
(only print the number if it's not divisible by 3, 5 or 7)

Notice that the word associated with the lowest number, is always printed
first and the word associated with the higest number is printed last.

Make sure your tests are updated!


## Let's make it more advanced!

Now we're going to take this challenge to a whole other level. We're going to 
make everything user configurable. If you have structured your code well and
separated things out, this should work well. However you will probably have to 
refactor some stuff. 

So now you need to build a more complex form, that allows the user to specify
three 'word factors'. Each word factor consists of:

* the word that should be printed out
* the number associated with the word that we use to know when to print the word

The user should still be able to specify the lower and upper limits for you to
iterate, but now you will be printing the words the user specifies as well,
and only printing them when the number is divisible by the number associated
with the word.

For example, let's say the user gives us the limits `52` and `267`, then the
following word factors as well:

* 4 blah
* 8 foo
* 9 bar

You need follow the requirements specified in the last challeng 
(Adding another word) except with these numbers and words instead.
