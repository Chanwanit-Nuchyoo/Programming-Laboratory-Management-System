def staircase(n, a=1):
    if n > 0 and n >= a:
        s = "_"*(n-a)+"#"*a
        if n >= a+1:
            s += "\n"
        return s+staircase(n, a+1)
    elif n < 0 and abs(n) >= a:
        s = "_"*(a-1)+"#"*(abs(n)-a+1)
        if abs(n) >= a+1:
            s += "\n"
        return s+staircase(n, a+1)
    elif n == 0:
        return "Not Draw!"
    return ""
print(staircase(int(input("Enter Input : "))))