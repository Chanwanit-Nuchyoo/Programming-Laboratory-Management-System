def sort_by_letter(lst):
    arr = []
    for x in lst:
        for i in x:
            if i.isalpha():
                arr.append([ord(i), x])
                break
    for i in range(len(arr)):
        for j in range(i+1, len(arr)):
            if arr[j][0] < arr[i][0]:
                arr[j][0], arr[i][0] = arr[i][0], arr[j][0]
                lst[j], lst[i] = lst[i], lst[j]
    return ' '.join(lst)

inp = input('Enter Input : ').split()
print(sort_by_letter(inp))