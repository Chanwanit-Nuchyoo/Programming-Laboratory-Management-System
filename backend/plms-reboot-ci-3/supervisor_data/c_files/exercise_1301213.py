def pos_neg_sort(lst):
    for i in range(len(lst)):
        for j in range(i + 1, len(lst)):
            if lst[j] >= 0 and lst[j] < lst[i]:
                lst[i], lst[j] = lst[j], lst[i]
    return ' '.join(str(i) for i in lst)

inp = [int(i) for i in input('Enter Input : ').split()]
print(pos_neg_sort(inp))