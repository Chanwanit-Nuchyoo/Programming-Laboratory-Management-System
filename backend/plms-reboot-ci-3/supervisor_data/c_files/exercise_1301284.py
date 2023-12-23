arr = [int(i) for i in input('Enter All Bid : ').split()]
arr.sort()
if len(arr) == 1:
    print("not enough bidder")
elif arr[-1] == arr[-2]:
    print("error : have more than one highest bid")
else:
    print("winner bid is",arr[-1],"need to pay",arr[-2])