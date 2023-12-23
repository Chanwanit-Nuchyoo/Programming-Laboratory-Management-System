def most_frequent(lst):
    counter = 0
    num = lst[0]

    for i in lst:
        curr_frequency = lst.count(i)
        if(curr_frequency > counter):
            counter = curr_frequency
            num = i

    return num


print("*** Maximum Occurrence ***")
lst = list(map(int, input("Enter some numbers: ").split()))
print(most_frequent(lst))
