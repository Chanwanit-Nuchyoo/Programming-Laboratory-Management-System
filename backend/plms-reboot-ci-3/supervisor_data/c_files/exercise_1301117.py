print("*** Reading E-Book ***")
text,substr = input('Text , Highlight : ').split(",")
str, cnt = text, 0
ans = ""
while True:
    index = str[cnt:].find(substr)
    if index == -1:
        ans += str[cnt:]
        break
    arr = list(str[cnt:])
    arr.insert(index, '[')
    arr.insert(index + len(substr) + 1, ']')
    str, cnt = ''.join(arr), index + len(substr) + 2
    ans += str[0:index + len(substr) + 2]
print(ans)