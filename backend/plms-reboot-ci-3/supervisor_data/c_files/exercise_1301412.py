line, num = input('Enter a word and a number: ').split()
num = int(num)

if num < 1 or num > 26:
    print('Number must be between 1-26')
    quit()

num = 26 - num
out = ""
for character in line:
    ascii_code = ord(character.upper())
    temp = ord('A') + ((ascii_code - ord('A') + num) % 26)
    out += chr(temp)
print(out)
