print(" *** Data type integer float string ***")
a = input("Enter a word : ")
try:
    a = int(a)
    aType = 'int'
except:
    try:
        a = float(a)
        aType = 'float'
    except:
        aType = "string"
if aType=="int":
    print("{0} * 2 = {1}".format(a,a*2))
elif aType=='float':
    print("{0:0.3f} / 3 = {1:0.3f}".format(a,a/3))
else:
    print('{0} {0} {0}'.format(a))
