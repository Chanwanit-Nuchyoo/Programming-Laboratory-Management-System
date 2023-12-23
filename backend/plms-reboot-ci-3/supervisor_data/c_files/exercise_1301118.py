print("*** Election ***")
n = int(input('Enter a number of voter(s) : '))
arr = [0] * 21
s = [int(i) for i in input().split(' ')]
for i in s:
    if (i >= 1) and (i <= 20):
        arr[i] += 1
max = max(arr)
if max == 0:
    print('*** No Candidate Wins ***')
else:
    for i in range(1, 21):
        if arr[i] == max:
            print(i, end=' ')