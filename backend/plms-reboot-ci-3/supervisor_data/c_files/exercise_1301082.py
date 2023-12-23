

print("*** Converting hh.mm.ss to seconds ***")
h,m,s = input("Enter hh mm ss : ").split()
h=int(h)
m=int(m)
s=int(s)
print(h,m,s)
if m > 59 or m<0:
    print("mm({}) is invalid!".format(m))    
elif s > 59 or s<0:
    print("ss({}) is invalid!".format(s))
else:
    seconds = h*3600+m*60+s
    print("{:02}:{:02}:{:02} = {:,} seconds".format(h,m,s,seconds))