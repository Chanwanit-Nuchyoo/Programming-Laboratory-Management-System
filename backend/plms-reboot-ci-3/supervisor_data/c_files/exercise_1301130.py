def odd_even(arr, s):
    if s == "Even":
        return arr[1::2]
    return arr[0::2]

print("*** Odd Even ***")
s = input('Enter Input : ').split(',')
if s[0] == "L":
    print(odd_even(s[1].split(),s[2]))
elif s[0] == "S":
    print(odd_even(s[1],s[2]))