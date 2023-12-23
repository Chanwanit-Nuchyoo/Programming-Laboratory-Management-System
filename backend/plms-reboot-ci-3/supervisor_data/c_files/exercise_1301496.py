def diff(a,b):
    x1,y1 = a
    x2,y2 = b
    #print(x1,y1,x2,y2)
    return (x2-x1,y2-y1)
# end function
print(" *** Find difference between A(x1,y1) and B(x2,y2) ***")
ins = input("Enter x1 y1 x2 y2 : ").split()

pointA= (int(ins[0]),int(ins[1]))
pointB= (int(ins[2]),int(ins[3]))

print("A B ==>",pointA,pointB)
print("Differnce from", pointA,"to", pointB,"==>",diff(pointA,pointB))
print("Differnce from", pointB,"to", pointA,"==>",diff(pointB,pointA))