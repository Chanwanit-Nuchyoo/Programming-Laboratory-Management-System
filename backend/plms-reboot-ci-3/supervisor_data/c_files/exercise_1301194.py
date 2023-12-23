def dectobinary(arr, start, end):
    if end == start:
        print(''.join(str(i) for i in arr))
    else:
        arr[start] = 0
        dectobinary(arr, start + 1, end)
        arr[start] = 1
        dectobinary(arr, start + 1, end)

inp = int(input('Enter Number : '))
if inp < 0:
    print('Only Positive & Zero Number ! ! !')
elif inp == 0:
    print(0)
else:
    dectobinary([0] * inp, 0, inp)