def string_test(s):
    d={"UPPER_CASE":0, "LOWER_CASE":0}
    upls = set()
    lols = set()
    for c in s:
        if c.isupper():
           d["UPPER_CASE"]+=1
           upls.add(c)
        elif c.islower():
           d["LOWER_CASE"]+=1
           lols.add(c)
        else:
           pass
    print ("No. of Upper case characters :", d["UPPER_CASE"])
    print ("Unique Upper case characters : ",end='')
    for ele in sorted(upls): print(ele,' ',end='')
    print ("\nNo. of Lower case Characters :", d["LOWER_CASE"])
    print ("Unique Lower case characters : ",end='')
    for ele in sorted(lols): print(ele,' ',end='') 

print(" *** String count ***")
str1 = input("Enter message : ")
string_test(str1)