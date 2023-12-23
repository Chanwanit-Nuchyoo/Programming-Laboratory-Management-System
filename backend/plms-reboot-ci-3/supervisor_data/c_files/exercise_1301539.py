inp = input('Enter a sequence of integers: ').split()
largest1 = None
largest2 = None

for i in inp:
    i = int(i)
    if i % 2 != 0:
        continue
    if largest2 is None and largest1 is not None:
        largest2 = i
    if largest1 is None:
        largest1 = i
    if largest2 is not None and i > largest2:
        largest2 = i
    if largest1 is not None and i > largest1:
        largest2 = largest1
        largest1 = i

if largest1 is not None and largest2 is not None:
    print('The largest even integer is', largest1)
    print('The second-largest even integer is', largest2)
else:
    print('Insufficient input data')
