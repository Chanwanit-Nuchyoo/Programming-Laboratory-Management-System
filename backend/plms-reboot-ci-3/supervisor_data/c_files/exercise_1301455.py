def least_frequent(lst):
    count = len(lst)+1
    least = lst[0]
    for num in lst:
        if lst.count(num) < count:
            count = lst.count(num)
            least = num
    return least


print("*** Minimum Occurrence ***")
lst = list(map(int, input("Enter some numbers: ").split()))
print(least_frequent(lst))
