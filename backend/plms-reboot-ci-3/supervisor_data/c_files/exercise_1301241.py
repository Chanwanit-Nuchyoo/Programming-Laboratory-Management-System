inp, tmp = input('Enter Input : ').split('/'), 1
vans, books = [[int(i), 0] for i in range(1, int(inp[0]) + 1)], [int(i) for i in inp[1].split()]
for book in books:
    print("Customer {2} Booking Van {0} | {1} day(s)".format(vans[0][0], book, tmp))
    vans[0][1] += book
    tmp += 1
    vans = sorted(vans, key = lambda x: (x[1], x[0]))