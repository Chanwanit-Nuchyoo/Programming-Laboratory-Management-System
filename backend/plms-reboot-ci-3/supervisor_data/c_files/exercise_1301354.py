print(" *** Transform second ***")
str = input("Enter seconds : ")
ok = False
try:
    num = int(str)
    ok = True
except:
    print("! ! ! please enter in whole number -->",str)
    print(" --- program end --- ")
if ok :
    seconds = num%60
    minutes = num//60%60
    hours = num//60//60%24
    days = num//60//60//24%7
    weeks = num//60//60//24//7
    print(num,"seconds ==> ",end='')
    if weeks>0: 
        print(weeks,"weeks ",end='')
    if days>0: 
        print(days,"days ",end='')
    if hours>0:
        print(hours,"hours ",end='')
    if minutes>0:
        print(minutes,"minutes ",end='')
    if seconds>0:
        print(seconds,"seconds",end='')
    print("\n --- program end --- ")

