print(" *** Number Manipulation ***")
input = input("Enter a whole number : ")
input = int(input)
if( input%2 == 0):
    print("{} is even.".format(input))
else :
    print("{} is odd.".format(input))
if(input>0):
    print('absolute value of {0} ==> {0}'.format(input))
else :
    print('absolute value of {0} ==> {1}'.format(input,input*-1))