def length(txt):     
    if txt:
        x = length(txt[:-1])+1
        if x%2==0:
            print(txt[-1],end="~")
        else:
            print(txt[-1],end="*")
        return x
    return 0

print("\n",length(input("Enter Input : ")),sep="")